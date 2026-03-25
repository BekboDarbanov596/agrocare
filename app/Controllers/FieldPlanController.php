<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use App\AI\ChatAPI;
use PDO;

class FieldPlanController
{
    private Database $db;
    private PDO $pdo;
    private Auth $auth;
    private ChatAPI $chatAPI;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
        $this->auth = new Auth();
        $this->chatAPI = new ChatAPI();
    }

    /**
     * Создание плана участка с AI анализом
     */
    public function create(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $fieldId = $body['field_id'] ?? '';
        $crop = $body['crop'] ?? '';
        $areaHectares = isset($body['area_hectares']) ? (float) $body['area_hectares'] : null;
        $region = $body['region'] ?? '';
        $city = $body['city'] ?? ''; // New field for city/location
        $startDate = $body['start_date'] ?? date('Y-m-d');
        $goal = $body['goal'] ?? '';
        $budget = $body['budget'] ?? '';
        $plannedSowingDate = $body['planned_sowing_date'] ?? '';
        $sowingMethod = $body['sowing_method'] ?? '';
        $predecessor = $body['predecessor'] ?? '';
        $monoculture = $body['monoculture'] ?? '';
        $cropHistory = $body['crop_history'] ?? [];
        $additionalInfo = $body['additional_info'] ?? [];

        if (empty($fieldId) || empty($crop)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Выберите участок и укажите культуру']);
        }

        // Валидация ID
        if (!is_numeric($fieldId)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Неверный ID участка.']);
        }

        $userId = $this->auth->userId();

        // Получаем информацию об участке и историю посевов
        try {
            $fieldInfo = $this->getFieldInfo($fieldId, $userId);
            if (!$fieldInfo) {
                http_response_code(404);
                return json_encode(['success' => false, 'error' => 'Участок не найден или нет доступа']);
            }
        } catch (\Exception $e) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Ошибка при получении данных участка: ' . $e->getMessage()]);
        }

        // Получаем историю посевов за 3 года
        try {
            $history = $this->getCropHistory($fieldId);
        } catch (\Exception $e) {
            $history = [];
        }

        // Формируем запрос к AI с учетом всех данных
        $aiMessage = $this->buildAIRequest(
            $fieldInfo,
            $history,
            $crop,
            $region,
            $areaHectares,
            $startDate,
            $goal,
            $budget,
            $plannedSowingDate,
            $sowingMethod,
            $predecessor,
            $monoculture,
            $cropHistory,
            $additionalInfo,
            $city // Pass city to AI request builder
        );

        // Отправляем в AI (с обработкой ошибок)
        $aiResult = ['success' => false, 'message' => ''];
        try {
            $aiResult = $this->chatAPI->sendMessage(
                $userId,
                $aiMessage,
                'plan_advice',
                null, // context_id будет установлен после создания плана
                [
                    'region' => $region ?: $fieldInfo['farm_region'] ?? 'регионе',
                    'crop' => $crop,
                    'field_id' => $fieldId
                ]
            );
        } catch (\Exception $e) {
            error_log("AI Error: " . $e->getMessage());
            $aiResult = [
                'success' => false,
                'error' => 'AI анализ временно недоступен. План будет создан без AI рекомендаций.'
            ];
        }

        // Для парсинга структуры используем raw-ответ (если доступен),
        // а пользователю показываем очищенный текст без технических блоков.
        $rawAiMessage = $aiResult['metadata']['raw_content'] ?? ($aiResult['message'] ?? '');
        $cleanAiMessage = $aiResult['message'] ?? '';
        $aiResultForParse = $aiResult;
        $aiResultForParse['message'] = $rawAiMessage;

        // Формируем план на основе ответа AI
        $planData = $this->parseAIPlanResponse($aiResultForParse, $crop, $startDate, $areaHectares, $region, $cropHistory, $additionalInfo);
        if ($aiResult['success'] && !empty($cleanAiMessage)) {
            $planData['ai_analysis'] = $cleanAiMessage;
        }

        // Сохраняем план
        try {
            $sql = "INSERT INTO field_plans (field_id, region, crop, area_hectares, start_date, plan_data, risks, status, created_by)
                    VALUES (:field_id, :region, :crop, :area_hectares, :start_date, :plan_data, :risks, 'draft', :created_by)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':field_id' => $fieldId,
                ':region' => $region ?: null,
                ':crop' => $crop,
                ':area_hectares' => $areaHectares,
                ':start_date' => $startDate,
                ':plan_data' => json_encode($planData),
                ':risks' => json_encode($planData['risks'] ?? []),
                ':created_by' => $userId
            ]);

            $planId = $this->pdo->lastInsertId();

            // Обновляем context_id для сообщений, которые были сохранены с context_id = NULL
            // Это происходит потому что sendMessage вызывается до создания плана
            try {
                $updateSql = "UPDATE ai_messages
                             SET context_id = :plan_id
                             WHERE user_id = :user_id
                               AND context_type = 'plan_advice'
                               AND context_id IS NULL
                               AND created_at > NOW() - INTERVAL 5 MINUTE";
                $updateStmt = $this->pdo->prepare($updateSql);
                $updateStmt->execute([
                    ':plan_id' => $planId,
                    ':user_id' => $userId
                ]);
                $updatedCount = $updateStmt->rowCount();
                error_log("Updated $updatedCount messages with plan_id=$planId");
            } catch (\Exception $e) {
                error_log("Failed to update context_id for messages: " . $e->getMessage());
            }

            // Если анализ не был сохранен через sendMessage (например, если он был сохранен с NULL),
            // сохраняем его еще раз с правильным context_id
            if ($aiResult['success'] && !empty($cleanAiMessage)) {
                try {
                    $messageText = $cleanAiMessage;
                    $messageLength = strlen($messageText);
                    error_log("Ensuring AI analysis is in chat history: plan_id=$planId, length=$messageLength");

                    // Проверяем, есть ли уже сообщение assistant для этого плана
                    $checkSql = "SELECT COUNT(*) as count FROM ai_messages
                                WHERE user_id = :user_id
                                  AND context_type = 'plan_advice'
                                  AND context_id = :plan_id
                                  AND role = 'assistant'";
                    $checkStmt = $this->pdo->prepare($checkSql);
                    $checkStmt->execute([':user_id' => $userId, ':plan_id' => $planId]);
                    $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

                    // Если нет сообщений assistant, сохраняем
                    if ($checkResult['count'] == 0) {
                        $this->chatAPI->saveMessageDirectly(
                            $userId,
                            'assistant',
                            $messageText,
                            'plan_advice',
                            $planId
                        );
                        error_log("AI analysis saved to chat history for plan_id=$planId");
                    } else {
                        error_log("AI analysis already exists in chat history for plan_id=$planId");
                    }
                } catch (\Exception $e) {
                    error_log("Failed to save AI analysis to chat history: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
                }
            } else {
                error_log("AI analysis not saved: success=" . ($aiResult['success'] ? 'true' : 'false') . ", message_empty=" . (empty($aiResult['message']) ? 'true' : 'false'));
            }

            return json_encode([
                'success' => true,
                'plan_id' => $planId,
                'plan' => $planData,
                'ai_analysis' => $aiResult['success'] ? $cleanAiMessage : null
            ]);
        } catch (\Exception $e) {
            error_log("Plan creation error: " . $e->getMessage());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка при сохранении плана: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Получение информации об участке
     */
    private function getFieldInfo(string $fieldId, string $userId): ?array
    {
        $sql = "SELECT f.*, fa.region as farm_region
                FROM fields f
                INNER JOIN farms fa ON f.farm_id = fa.id
                INNER JOIN user_farms uf ON fa.id = uf.farm_id
                WHERE f.id = :field_id AND uf.user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':field_id' => $fieldId, ':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Получение истории посевов за 3 года
     */
    private function getCropHistory(string $fieldId): array
    {
        $currentYear = (int) date('Y');
        $sql = "SELECT crop, year, yield, notes
                FROM crop_cycles
                WHERE field_id = :field_id
                  AND year >= :min_year
                ORDER BY year DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':field_id' => $fieldId,
            ':min_year' => $currentYear - 3
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Формирование запроса к AI
     */
    private function buildAIRequest(
        array $fieldInfo,
        array $history,
        string $crop,
        string $region,
        ?float $area,
        string $startDate,
        string $goal = '',
        string $budget = '',
        string $plannedSowingDate = '',
        string $sowingMethod = '',
        string $predecessor = '',
        string $monoculture = '',
        array $cropHistory = [],
        array $additionalInfo = [],
        string $city = '' // New parameter
    ): string {
        $message = "Ты агроном-консультант. Помоги составить детальный РАБОЧИЙ план работ для участка.\n\n";
        $message .= "ДАННЫЕ УЧАСТКА:\n";
        $message .= "- Название: {$fieldInfo['name']}\n";
        $message .= "- Площадь: " . ($area ?: $fieldInfo['area_ha'] ?? 'не указана') . " га\n";
        $message .= "- Регион: " . ($region ?: $fieldInfo['farm_region'] ?? 'Кыргызстан') . "\n";
        if ($city) {
            $message .= "- Город/Населенный пункт: {$city} (ВАЖНО: Изучи климат, типичные осадки и риски заморозков для этой локации)\n";
        }
        $message .= "- Планируемая культура: {$crop}\n";
        $message .= "- Дата начала сезона: {$startDate}\n";

        if ($goal) {
            $goalNames = [
                'maximum_yield' => 'Максимальный урожай',
                'minimal_costs' => 'Минимальные затраты',
                'organic' => 'Органическое производство',
                'feed' => 'На корм скоту',
                'seed' => 'На семена',
                'quality' => 'Высокое качество продукции',
                'balanced' => 'Сбалансированный подход'
            ];
            $message .= "- Цель выращивания: " . ($goalNames[$goal] ?? $goal) . "\n";
        }

        if ($budget) {
            $budgetNames = [
                'minimal' => 'Минимальный (экономный)',
                'medium' => 'Средний (стандартный)',
                'unlimited' => 'Свободный (максимальная эффективность)'
            ];
            $message .= "- Бюджет: " . ($budgetNames[$budget] ?? $budget) . "\n";
        }

        if ($plannedSowingDate) {
            $message .= "- Запланированная дата посева: {$plannedSowingDate}\n";
        }

        if ($sowingMethod) {
            $methodNames = [
                'row' => 'Рядовой посев',
                'precision' => 'Точный посев',
                'seedlings' => 'Рассадой',
                'broadcast' => 'Разбросной посев',
                'strip' => 'Полосовой посев'
            ];
            $message .= "- Способ посева: " . ($methodNames[$sowingMethod] ?? $sowingMethod) . "\n";
        }

        if ($predecessor) {
            $message .= "- Предшественник (культура прошлого года): {$predecessor}\n";
        }

        if ($monoculture) {
            $message .= "- Монокультура: " . ($monoculture === 'yes' ? 'Да, одна и та же культура несколько лет' : 'Нет, чередовали культуры') . "\n";
        }

        // Добавляем историю посевов из базы данных (если есть)
        if (!empty($history)) {
            $message .= "\nИСТОРИЯ ПОСЕВОВ ИЗ БАЗЫ ДАННЫХ:\n";
            foreach ($history as $h) {
                $message .= "- {$h['year']} год: {$h['crop']}";
                if (isset($h['yield']) && $h['yield']) {
                    $message .= " (урожай: {$h['yield']} т/га)";
                }
                $message .= "\n";
            }
        }

        // Добавляем историю посевов из формы (более детальная)
        if (!empty($cropHistory)) {
            $message .= "\nДЕТАЛЬНАЯ ИСТОРИЯ ПОСЕВОВ (из формы):\n";

            // Проверяем наличие структурированной истории за последние 2 года
            if (isset($cropHistory['last_year'])) {
                $message .= "- Прошлый год: " . ($cropHistory['last_year']['crop'] ?? 'неизвестно') . ", Урожайность: " . ($cropHistory['last_year']['yield'] ?? 'не указана') . " т/га\n";
            }
            if (isset($cropHistory['year_before'])) {
                $message .= "- Позапрошлый год: " . ($cropHistory['year_before']['crop'] ?? 'неизвестно') . ", Урожайность: " . ($cropHistory['year_before']['yield'] ?? 'не указана') . " т/га\n";
            }

            // Обработка других записей истории
            foreach ($cropHistory as $yearKey => $yearData) {
                if (is_array($yearData) && !in_array($yearKey, ['last_year', 'year_before']) && !empty($yearData['crop'])) {
                    $message .= "- {$yearData['year']} год: {$yearData['crop']}";
                    if (!empty($yearData['yield'])) {
                        $message .= " (урожайность: {$yearData['yield']} ц/га)";
                    }
                    if (!empty($yearData['notes'])) {
                        $message .= ". Примечания: {$yearData['notes']}";
                    }
                    $message .= "\n";
                }
            }
        }

        if (empty($history) && empty($cropHistory)) {
            $message .= "\nИстория посевов: нет данных\n";
        }

        // Добавляем дополнительную информацию о почве и условиях
        if (!empty($additionalInfo)) {
            $message .= "\nПОЧВА И УСЛОВИЯ:\n";
            if (!empty($additionalInfo['soilType'])) {
                $message .= "- Тип почвы: {$additionalInfo['soilType']}\n";
            }
            if (!empty($additionalInfo['soilTexture'])) {
                $message .= "- Текстура/механический состав: {$additionalInfo['soilTexture']}\n";
            }
            if (!empty($additionalInfo['soilPH'])) {
                $message .= "- Кислотность почвы (pH): {$additionalInfo['soilPH']}\n";
            }
            if (!empty($additionalInfo['irrigation'])) {
                $message .= "- Тип орошения: {$additionalInfo['irrigation']}\n";
            }
            if (!empty($additionalInfo['waterSource'])) {
                $message .= "- Источник воды: {$additionalInfo['waterSource']}\n";
            }
            if (!empty($additionalInfo['waterAvailability'])) {
                $message .= "- Доступность воды: {$additionalInfo['waterAvailability']}\n";
            }
            if (!empty($additionalInfo['mechanization'])) {
                $message .= "- Механизация: {$additionalInfo['mechanization']}\n";
            }
            if (!empty($additionalInfo['altitude'])) {
                $message .= "- Высота над уровнем моря: {$additionalInfo['altitude']} м\n";
            }
            if (!empty($additionalInfo['slope'])) {
                $message .= "- Уклон участка: {$additionalInfo['slope']}%\n";
            }
            if (!empty($additionalInfo['drainage'])) {
                $message .= "- Дренаж: {$additionalInfo['drainage']}\n";
            }
            if (!empty($additionalInfo['averageYield'])) {
                $message .= "- Средняя урожайность по участку: {$additionalInfo['averageYield']} ц/га\n";
            }

            // Анализ почвы
            if (!empty($additionalInfo['soilN']) || !empty($additionalInfo['soilP']) || !empty($additionalInfo['soilK']) || !empty($additionalInfo['soilHumus'])) {
                $message .= "\nАНАЛИЗ ПОЧВЫ:\n";
                if (!empty($additionalInfo['soilN'])) {
                    $message .= "- Азот (N): {$additionalInfo['soilN']} мг/кг\n";
                }
                if (!empty($additionalInfo['soilP'])) {
                    $message .= "- Фосфор (P): {$additionalInfo['soilP']} мг/кг\n";
                }
                if (!empty($additionalInfo['soilK'])) {
                    $message .= "- Калий (K): {$additionalInfo['soilK']} мг/кг\n";
                }
                if (!empty($additionalInfo['soilHumus'])) {
                    $message .= "- Гумус/органика: {$additionalInfo['soilHumus']}%\n";
                }
            }

            // Проблемы
            if (!empty($additionalInfo['problems']) && is_array($additionalInfo['problems'])) {
                $message .= "\nПРОБЛЕМЫ НА УЧАСТКЕ:\n";
                $message .= "- " . implode(", ", $additionalInfo['problems']) . "\n";
            }

            if (!empty($additionalInfo['fertilizers'])) {
                $message .= "- Удобрения: {$additionalInfo['fertilizers']}\n";
            }

            if (!empty($additionalInfo['pesticides'])) {
                $message .= "- СЗР (средства защиты растений): {$additionalInfo['pesticides']}\n";
            }

            if (!empty($additionalInfo['fieldNotes'])) {
                $message .= "- Другие особенности: {$additionalInfo['fieldNotes']}\n";
            }
        }

        $message .= "\nЗАДАЧА:\n";
        $message .= "Создай ДЕТАЛЬНЫЙ РАБОЧИЙ ПЛАН с конкретными действиями, датами, дозировками и технологиями.\n\n";

        $message .= "1. ОЦЕНКА ПРИГОДНОСТИ И УСЛОВИЙ:\n";
        $message .= "   - Подходит ли {$crop} для региона " . ($region ?: $fieldInfo['farm_region'] ?? '') . " с учетом всех указанных условий?\n";
        $message .= "   - Оценка почвы и рекомендации по улучшению\n";
        if ($predecessor) {
            $message .= "   - Учет предшественника ({$predecessor}) и монокультуры\n";
        }
        if ($goal) {
            $message .= "   - Учет цели выращивания и бюджета\n";
        }
        $message .= "\n";

        $message .= "2. КАЛЕНДАРЬ РАБОТ (КОНКРЕТНЫЕ ДАТЫ И ДЕЙСТВИЯ):\n";
        $message .= "   - Подготовка почвы: конкретные даты, виды работ, глубина обработки\n";
        if ($plannedSowingDate) {
            $message .= "   - Посев: {$plannedSowingDate} (способ: " . ($sowingMethod ?: 'рекомендуемый') . ")\n";
        } else {
            $message .= "   - Посев: оптимальные сроки с учетом региона и культуры, способ посева\n";
        }
        $message .= "   - Подкормки: конкретные даты, виды удобрений, дозировки (кг/га или г/м²)\n";
        $message .= "   - Обработки СЗР: даты, препараты, дозировки, против чего\n";
        if (!empty($additionalInfo['irrigation']) && $additionalInfo['irrigation'] !== 'нет') {
            $message .= "   - Полив: режим, объемы, сроки\n";
        }
        $message .= "   - Уход: прополка, рыхление, окучивание (если нужно) с датами\n";
        $message .= "   - Уборка урожая: оптимальные сроки, признаки готовности\n\n";

        $message .= "3. ТЕХНОЛОГИЯ И СРЕДСТВА:\n";
        if (!empty($additionalInfo['fertilizers'])) {
            $message .= "   - Удобрения: {$additionalInfo['fertilizers']} - конкретные виды, дозировки, сроки внесения\n";
        } else {
            $message .= "   - Удобрения: рекомендации с учетом бюджета и цели\n";
        }
        if (!empty($additionalInfo['pesticides'])) {
            $message .= "   - СЗР: {$additionalInfo['pesticides']} - конкретные препараты, дозировки, сроки\n";
        } else {
            $message .= "   - СЗР: рекомендации по защите растений\n";
        }
        if (!empty($additionalInfo['mechanization'])) {
            $message .= "   - Учет механизации: {$additionalInfo['mechanization']}\n";
        }
        $message .= "\n";

        $message .= "4. РИСКИ И ПРОБЛЕМЫ:\n";
        if (!empty($additionalInfo['problems']) && is_array($additionalInfo['problems'])) {
            $message .= "   - Учет указанных проблем: " . implode(", ", $additionalInfo['problems']) . "\n";
        }
        $message .= "   - Климатические риски для {$crop} в регионе " . ($region ?: $fieldInfo['farm_region'] ?? '') . "\n";
        $message .= "   - Возможные болезни и вредители (с учетом предшественника и истории)\n";
        $message .= "   - Конкретные меры профилактики и борьбы\n\n";

        $message .= "5. РЕКОМЕНДАЦИИ:\n";
        $message .= "   - По улучшению почвы (с учетом анализа и текстуры)\n";
        $message .= "   - По севообороту (что сеять после {$crop} с учетом истории)\n";
        $message .= "   - По повышению урожайности (с учетом цели и бюджета)\n";
        if (!empty($history) || !empty($cropHistory)) {
            $message .= "   - С учетом истории посевов и истощения почвы\n";
        }
        if ($goal === 'organic') {
            $message .= "   - Особенности органического производства\n";
        }
        if ($budget === 'minimal') {
            $message .= "   - Экономичные решения и оптимизация затрат\n";
        }

        $message .= "\nФОРМАТ ОТВЕТА (ОБЯЗАТЕЛЬНО):\n";
        $message .= "1) Сначала понятный текст для фермера с разделами.\n";
        $message .= "2) В конце добавь блок JSON между маркерами START_PLAN_JSON и END_PLAN_JSON.\n";
        $message .= "3) JSON-структура:\n";
        $message .= "{\n";
        $message .= '  "tasks": [{"title":"", "due_date":"YYYY-MM-DD", "priority":"high|medium|low", "stage":"soil|sowing|nutrition|protection|irrigation|harvest"}],' . "\n";
        $message .= '  "risks": [{"level":"critical|medium|low", "type":"climate|disease|pest|soil|finance", "description":""}],' . "\n";
        $message .= '  "kpi": {"yield_t_ha": 0, "cost_index": 100, "risk_index": 50}' . "\n";
        $message .= "}\n";
        $message .= "4) Если нет точной даты, рассчитай ее относительно даты начала сезона.\n";
        $message .= "5) Используй только валидный JSON без комментариев.\n";
        $message .= "\nВАЖНО:\n";
        $message .= "- Дай РАБОЧИЙ план, а не общие рекомендации\n";
        $message .= "- Указывай конкретные даты (можно относительно даты начала сезона)\n";
        $message .= "- Указывай конкретные дозировки удобрений и препаратов\n";
        $message .= "- Учитывай все указанные условия: почву, орошение, механизацию, бюджет\n";
        $message .= "- Если данных по почве не предоставлено, используй средние агрономические показатели для региона: " . ($region ?: $fieldInfo['farm_region'] ?? 'Кыргызстан') . "\n";
        $message .= "- Структурируй ответ с четкими разделами для удобства\n";
        $message .= "- Отвечай на русском языке, конкретно и по делу";

        return $message;
    }

    /**
     * Парсинг ответа AI в структуру плана
     */
    private function parseAIPlanResponse(array $aiResult, string $crop, string $startDate, ?float $areaHectares = null, string $region = '', array $cropHistory = [], array $additionalInfo = []): array
    {
        $structured = $this->extractStructuredPlanFromAI($aiResult['message'] ?? '');

        $plan = [
            'crop' => $crop,
            'start_date' => $startDate,
            'area_hectares' => $areaHectares,
            'region' => $region,
            'crop_history' => $cropHistory,
            'additional_info' => $additionalInfo,
            'tasks' => $structured['tasks'] ?? [],
            'risks' => $structured['risks'] ?? [],
            'kpi' => $structured['kpi'] ?? [],
            'recommendations' => [],
            'ai_analysis' => $aiResult['success'] ? $aiResult['message'] : 'AI анализ недоступен'
        ];

        // Fallback, если AI не вернул структурированный блок
        if ($aiResult['success']) {
            $text = $aiResult['message'];

            if (empty($plan['risks']) && (stripos($text, 'риск') !== false || stripos($text, 'опасность') !== false)) {
                $plan['risks'][] = [
                    'level' => 'medium',
                    'type' => 'climate',
                    'description' => 'Климатические риски выявлены AI'
                ];
            }

            if (empty($plan['tasks'])) {
                $plan['tasks'] = [
                    ['title' => 'Подготовка почвы', 'due_date' => $startDate, 'priority' => 'high', 'stage' => 'soil'],
                    ['title' => 'Посев ' . $crop, 'due_date' => date('Y-m-d', strtotime($startDate . ' +7 days')), 'priority' => 'high', 'stage' => 'sowing'],
                    ['title' => 'Первая подкормка', 'due_date' => date('Y-m-d', strtotime($startDate . ' +30 days')), 'priority' => 'medium', 'stage' => 'nutrition']
                ];
            }

            if (empty($plan['kpi'])) {
                $plan['kpi'] = [
                    'yield_t_ha' => null,
                    'cost_index' => 100,
                    'risk_index' => count($plan['risks']) > 0 ? 55 : 40
                ];
            }
        }

        return $plan;
    }

    private function extractStructuredPlanFromAI(string $text): array
    {
        if (empty($text)) {
            return [];
        }

        $jsonRaw = '';
        if (preg_match('/START_PLAN_JSON\s*(\{.*?\})\s*END_PLAN_JSON/s', $text, $m)) {
            $jsonRaw = $m[1];
        } elseif (preg_match('/(\{(?:[^{}]|(?R))*"tasks"(?:[^{}]|(?R))*\})/s', $text, $m2)) {
            $jsonRaw = $m2[1];
        }

        if (empty($jsonRaw)) {
            return [];
        }

        $decoded = json_decode($jsonRaw, true);
        if (!is_array($decoded)) {
            return [];
        }

        $tasks = [];
        if (isset($decoded['tasks']) && is_array($decoded['tasks'])) {
            foreach ($decoded['tasks'] as $task) {
                if (!is_array($task) || empty($task['title'])) {
                    continue;
                }
                $tasks[] = [
                    'title' => trim((string) $task['title']),
                    'due_date' => !empty($task['due_date']) ? (string) $task['due_date'] : '',
                    'priority' => in_array(($task['priority'] ?? ''), ['high', 'medium', 'low'], true) ? $task['priority'] : 'medium',
                    'stage' => !empty($task['stage']) ? (string) $task['stage'] : ''
                ];
            }
        }

        $risks = [];
        if (isset($decoded['risks']) && is_array($decoded['risks'])) {
            foreach ($decoded['risks'] as $risk) {
                if (!is_array($risk) || empty($risk['description'])) {
                    continue;
                }
                $risks[] = [
                    'level' => in_array(($risk['level'] ?? ''), ['critical', 'medium', 'low'], true) ? $risk['level'] : 'medium',
                    'type' => !empty($risk['type']) ? (string) $risk['type'] : 'general',
                    'description' => trim((string) $risk['description'])
                ];
            }
        }

        $kpi = [];
        if (isset($decoded['kpi']) && is_array($decoded['kpi'])) {
            $kpi = [
                'yield_t_ha' => isset($decoded['kpi']['yield_t_ha']) && is_numeric($decoded['kpi']['yield_t_ha']) ? (float) $decoded['kpi']['yield_t_ha'] : null,
                'cost_index' => isset($decoded['kpi']['cost_index']) && is_numeric($decoded['kpi']['cost_index']) ? (int) $decoded['kpi']['cost_index'] : 100,
                'risk_index' => isset($decoded['kpi']['risk_index']) && is_numeric($decoded['kpi']['risk_index']) ? (int) $decoded['kpi']['risk_index'] : 50,
            ];
        }

        return [
            'tasks' => $tasks,
            'risks' => $risks,
            'kpi' => $kpi
        ];
    }

    /**
     * Получение планов участка
     */
    public function index(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $fieldId = $body['field_id'] ?? $_GET['field_id'] ?? '';

        $userId = $this->auth->userId();

        // Если field_id = 'all', получаем все планы пользователя
        if ($fieldId === 'all' || empty($fieldId)) {
            $sql = "SELECT fp.* FROM field_plans fp
                    INNER JOIN fields f ON fp.field_id = f.id
                    INNER JOIN farms fa ON f.farm_id = fa.id
                    INNER JOIN user_farms uf ON fa.id = uf.farm_id
                    WHERE uf.user_id = :user_id
                    ORDER BY fp.created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Проверяем доступ
            $sql = "SELECT 1 FROM fields f
                    INNER JOIN farms fa ON f.farm_id = fa.id
                    INNER JOIN user_farms uf ON fa.id = uf.farm_id
                    WHERE f.id = :field_id AND uf.user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':field_id' => $fieldId, ':user_id' => $userId]);

            if (!$stmt->fetch()) {
                http_response_code(403);
                return json_encode(['success' => false, 'error' => 'Нет доступа']);
            }

            $sql = "SELECT * FROM field_plans WHERE field_id = :field_id ORDER BY created_at DESC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':field_id' => $fieldId]);
            $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return json_encode(['success' => true, 'plans' => $plans]);
    }
}
