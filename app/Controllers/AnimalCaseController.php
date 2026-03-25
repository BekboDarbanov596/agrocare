<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use App\AI\ChatAPI;
use PDO;

class AnimalCaseController
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
     * Создание кейса животного с AI триажем
     */
    public function create(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!$this->auth->check()) {
                http_response_code(401);
                return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
            }

            $body = $request->getBody();
            $userId = $this->auth->userId();

            // Получаем farm_id из первого хозяйства пользователя
            $sql = "SELECT farm_id FROM user_farms WHERE user_id = :user_id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $farm = $stmt->fetch(PDO::FETCH_ASSOC);

            // Если хозяйства нет, создаём автоматически
            if (!$farm) {
                $this->pdo->beginTransaction();
                try {
                    // Создаём хозяйство по умолчанию
                    $sql = "INSERT INTO farms (name, region, owner_id)
                            VALUES (:name, :region, :owner_id)";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':name' => 'Моё хозяйство',
                        ':region' => null,
                        ':owner_id' => $userId
                    ]);
                    $farmId = $this->pdo->lastInsertId();

                    // Связываем пользователя с хозяйством
                    $sql = "INSERT INTO user_farms (user_id, farm_id, role)
                            VALUES (:user_id, :farm_id, 'owner')";
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute([
                        ':user_id' => $userId,
                        ':farm_id' => $farmId
                    ]);

                    $this->pdo->commit();
                } catch (\Exception $e) {
                    $this->pdo->rollBack();
                    error_log("Failed to auto-create farm: " . $e->getMessage());
                    http_response_code(500);
                    return json_encode(['success' => false, 'error' => 'Ошибка создания хозяйства: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
                }
            } else {
                $farmId = $farm['farm_id'];
            }
            $species = $body['species'] ?? '';
            $ageWeight = $body['age_weight'] ?? '';
            $temperature = $body['temperature'] ?? null;
            $symptoms = $body['symptoms'] ?? '';

            // Дополнительная информация
            $diseaseStart = $body['disease_start'] ?? '';
            $treatmentHistory = $body['treatment_history'] ?? '';
            $feedingInfo = $body['feeding_info'] ?? '';
            $otherAnimals = $body['other_animals'] ?? '';
            $additionalNotes = $body['additional_notes'] ?? '';

            if (empty($species) || empty($symptoms)) {
                http_response_code(400);
                return json_encode(['success' => false, 'error' => 'Вид животного и симптомы обязательны'], JSON_UNESCAPED_UNICODE);
            }

            // Формируем детальный запрос к AI для триажа
            $speciesNames = [
                'cattle' => 'КРС (крупный рогатый скот)',
                'sheep' => 'овцы',
                'goat' => 'козы',
                'poultry' => 'птица',
                'pig' => 'свиньи',
                'horse' => 'лошади'
            ];
            $speciesName = $speciesNames[$species] ?? $species;

            $aiMessage = "Ты экспертный ветеринарный врач-диагност. Проведи глубокий клинический разбор случая.\n\n";

            $aiMessage .= "### 📋 КАРТА ЖИВОТНОГО\n";
            $aiMessage .= "- **Вид:** {$speciesName}\n";
            if ($ageWeight)
                $aiMessage .= "- **Возраст/вес:** {$ageWeight}\n";
            if ($temperature) {
                $normalTemp = match ($species) {
                    'cattle' => '38.0-39.5°C',
                    'sheep', 'goat' => '38.5-40.0°C',
                    'poultry' => '40.5-42.0°C',
                    'pig' => '38.5-39.5°C',
                    'horse' => '37.5-38.5°C',
                    default => '38.0-39.5°C'
                };
                $aiMessage .= "- **Температура:** {$temperature}°C (Норма: {$normalTemp})\n";
            }
            $aiMessage .= "- **Симптомы:** {$symptoms}\n";

            $hasExtraInfo = false; // Reset for new logic
            if ($diseaseStart || $treatmentHistory || $feedingInfo || $otherAnimals || $additionalNotes) {
                $aiMessage .= "\n### 📋 АНАМНЕЗ (КРИТИЧЕСКИ ВАЖНО)\n";
                if ($diseaseStart)
                    $aiMessage .= "- Время начала: {$diseaseStart}\n";
                if ($treatmentHistory)
                    $aiMessage .= "- Предыдущие действия/лекарства: {$treatmentHistory}\n";
                if ($feedingInfo)
                    $aiMessage .= "- Питание/вода: {$feedingInfo}\n";
                if ($otherAnimals)
                    $aiMessage .= "- Состояние стада/соседей: {$otherAnimals}\n";
                if ($additionalNotes)
                    $aiMessage .= "- Заметки владельца: {$additionalNotes}\n";
                $hasExtraInfo = true;
            }

            $aiMessage .= "\n--- 🩺 ИНСТРУКЦИЯ ПО ОТВЕТУ ---\n";
            $aiMessage .= "1. ПЕРВОЙ СТРОКОЙ укажи метку уровня срочности в формате: [[TRIAGE: LOW]] или [[TRIAGE: MEDIUM]] или [[TRIAGE: CRITICAL]]\n";
            $aiMessage .= "   * LOW: Стабильно. Режим наблюдения, уход.\n";
            $aiMessage .= "   * MEDIUM: Требуется осмотр в течение дня. Плановое лечение.\n";
            $aiMessage .= "   * CRITICAL: Угроза жизни. Немедленный вызов врача. Кровь, судороги, паралич, отек.\n\n";

            $aiMessage .= "2. **Дифференциальный диагноз:** Укажи 3 наиболее вероятных причины (болезни), объясни почему.\n";
            $aiMessage .= "3. **На что посмотреть (Clinical Signs):** Дай список из 3-4 конкретных признаков, которые владелец должен проверить прямо сейчас (цвет глаз/десен, частота дыхания в минуту, пульс, вздутие и т.д.).\n";
            $aiMessage .= "4. **Первая помощь:** Конкретные, безопасные действия. НИКАКИХ общих фраз 'обратитесь к врачу' без объяснения ЧТО ДЕЛАТЬ ДО ВРАЧА.\n";
            $aiMessage .= "5. **Риски:** Опиши опасные осложнения при отсутствии действий.\n\n";

            $aiMessage .= "--- ТРЕБОВАНИЯ К СТИЛЮ ---\n";
            $aiMessage .= "- СТРОГО: НЕ БОЛЕЕ 1 ЭМОДЗИ на весь ответ.\n";
            $aiMessage .= "- Тон: Профессиональный врач, сухой, конкретный, экспертный. Без 'воды' и лишней вежливости.\n";
            $aiMessage .= "- Избегай общих рекомендаций. Давай цифры (дозы, частота).\n";
            $aiMessage .= "- ОТВЕЧАЙ НА РУССКОМ ЯЗЫКЕ.\n";

            // Вызываем AI для анализа
            $aiResult = $this->chatAPI->sendMessage(
                $userId,
                $aiMessage,
                'animal_help',
                null,
                [
                    'species' => $species,
                    'age_weight' => $ageWeight,
                    'temperature' => $temperature,
                    'symptoms' => $symptoms
                ]
            );

            // Логируем результат AI для отладки
            if (!$aiResult['success']) {
                error_log("AI Error in AnimalCaseController: " . ($aiResult['error'] ?? 'Unknown error'));
                error_log("AI Response: " . json_encode($aiResult, JSON_UNESCAPED_UNICODE));
            }

            // Определяем уровень триажа из ответа AI
            $triageLevel = $this->parseTriageLevel($aiResult, $symptoms);

            // Ищем ветеринара если критично
            $vetInfo = null;
            if ($triageLevel === 'critical') {
                $vetInfo = $this->findVeterinarian();
            }

            // Сохраняем кейс
            $sql = "INSERT INTO animal_cases (farm_id, user_id, species, age_weight, temperature, symptoms, triage_level, recommendations, status)
                    VALUES (:farm_id, :user_id, :species, :age_weight, :temperature, :symptoms, :triage_level, :recommendations, 'created')";

            // Формируем рекомендации
            $aiResponse = $aiResult['success'] ? $aiResult['message'] : ('AI анализ недоступен. ' . ($aiResult['error'] ?? 'Ошибка подключения к AI сервису.'));

            // Вырезаем техническую метку из отображаемого текста
            $displayMessage = preg_replace('/\[\[TRIAGE:\s*(CRITICAL|MEDIUM|LOW)\s*\]\]/i', '', $aiResponse);
            $displayMessage = trim($displayMessage);

            $recommendations = [
                'ai_analysis' => $displayMessage,
                'triage_level' => $triageLevel,
                'vet_contact' => $vetInfo,
                'ai_error' => $aiResult['success'] ? null : ($aiResult['error'] ?? 'Unknown error')
            ];

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':farm_id' => $farmId,
                ':user_id' => $userId,
                ':species' => $species,
                ':age_weight' => $ageWeight ?: null,
                ':temperature' => $temperature,
                ':symptoms' => json_encode(['text' => $symptoms], JSON_UNESCAPED_UNICODE),
                ':triage_level' => $triageLevel,
                ':recommendations' => json_encode($recommendations, JSON_UNESCAPED_UNICODE)
            ]);

            $caseId = $this->pdo->lastInsertId();
            if (!$caseId) {
                error_log("Failed to create animal case");
                http_response_code(500);
                return json_encode(['success' => false, 'error' => 'Ошибка создания кейса'], JSON_UNESCAPED_UNICODE);
            }

            // Сохраняем AI анализ в историю чата для последующего обсуждения
            if ($aiResult['success']) {
                try {
                    // Обновляем context_id для сообщений после создания кейса
                    $this->chatAPI->updateMessagesContextId($userId, 'animal_help', $caseId);
                } catch (\Exception $e) {
                    error_log("Failed to update messages context_id: " . $e->getMessage());
                }
            }

            return json_encode([
                'success' => true,
                'case_id' => $caseId,
                'triage_level' => $triageLevel,
                'recommendations' => $recommendations,
                'vet_contact' => $vetInfo,
                'ai_success' => $aiResult['success'],
                'ai_error' => $aiResult['success'] ? null : ($aiResult['error'] ?? 'AI сервис недоступен')
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            error_log("Error in AnimalCaseController::create: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка сервера: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    private function parseTriageLevel(array $aiResult, string $symptoms): string
    {
        if (!$aiResult['success'] || empty($aiResult['message'])) {
            return 'medium'; // Fallback
        }

        $message = $aiResult['message'];

        // Ищем метку [[TRIAGE: ...]]
        if (preg_match('/\[\[TRIAGE:\s*(CRITICAL|MEDIUM|LOW)\]\]/i', $message, $matches)) {
            return strtolower($matches[1]);
        }

        // Если метка не найдена, используем упрощенный анализ текста для надежности
        $lowerMessage = mb_strtolower($message . ' ' . $symptoms);

        $criticalFlags = ['угроза жизни', 'немедлен', 'срочно вызов', 'судороги', 'шок'];
        foreach ($criticalFlags as $flag) {
            if (strpos($lowerMessage, $flag) !== false)
                return 'critical';
        }

        return 'medium'; // По умолчанию средне, если AI не дал четкой метки
    }

    /**
     * Поиск ветеринара
     */
    private function findVeterinarian(): ?array
    {
        $sql = "SELECT id, phone, email
                FROM users
                WHERE role = 'veterinarian'
                  AND is_active = true
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $vet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vet) {
            return [
                'id' => $vet['id'],
                'phone' => $vet['phone'] ?? '',
                'email' => $vet['email'] ?? ''
            ];
        }

        return null;
    }

    /**
     * Список кейсов
     */
    public function index(Request $request): string
    {
        // Очищаем любой вывод перед отправкой JSON
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Устанавливаем заголовки ДО любого вывода
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('X-Content-Type-Options: nosniff');
        }

        try {
            if (!$this->auth->check()) {
                http_response_code(401);
                return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
            }

            $userId = $this->auth->userId();

            // Fetch rows - in MySQL JSON columns are returned as strings by default in many PDO setups
            // or handled normally as JSON objects if available.
            $sql = "SELECT
                        id,
                        farm_id,
                        user_id,
                        species,
                        age_weight,
                        temperature,
                        symptoms as symptoms_json,
                        triage_level,
                        recommendations as recommendations_json,
                        status,
                        created_at,
                        updated_at
                    FROM animal_cases
                    WHERE user_id = :user_id
                    ORDER BY created_at DESC
                    LIMIT 50";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Обрабатываем JSONB поля
            foreach ($cases as &$case) {
                // Обрабатываем symptoms (JSONB)
                if (isset($case['symptoms_json']) && !empty($case['symptoms_json'])) {
                    $symptoms = json_decode($case['symptoms_json'], true);
                    $case['symptoms'] = $symptoms ?: ['text' => ''];
                } else {
                    $case['symptoms'] = ['text' => ''];
                }
                unset($case['symptoms_json']); // Удаляем временное поле

                // Обрабатываем recommendations (JSONB)
                if (isset($case['recommendations_json']) && !empty($case['recommendations_json'])) {
                    $recommendations = json_decode($case['recommendations_json'], true);
                    $case['recommendations'] = $recommendations ?: [];
                } else {
                    $case['recommendations'] = [];
                }
                unset($case['recommendations_json']); // Удаляем временное поле

                // Преобразуем даты в строки для JSON
                if (isset($case['created_at'])) {
                    $case['created_at'] = is_object($case['created_at']) ? $case['created_at']->format('Y-m-d H:i:s') : (string) $case['created_at'];
                }
                if (isset($case['updated_at'])) {
                    $case['updated_at'] = is_object($case['updated_at']) ? $case['updated_at']->format('Y-m-d H:i:s') : (string) $case['updated_at'];
                }

                // Убеждаемся, что все значения могут быть сериализованы в JSON
                foreach ($case as $key => $value) {
                    if (is_resource($value)) {
                        $case[$key] = null;
                    }
                }
            }
            unset($case); // Убираем ссылку

            $jsonResult = json_encode(['success' => true, 'cases' => $cases], JSON_UNESCAPED_UNICODE);

            if ($jsonResult === false) {
                $error = json_last_error_msg();
                error_log("JSON encode error: " . $error);
                error_log("Problematic data: " . print_r($cases, true));
                throw new \Exception("Ошибка кодирования JSON: " . $error);
            }

            return $jsonResult;
        } catch (\Exception $e) {
            error_log("Error in AnimalCaseController::index: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка загрузки кейсов: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
