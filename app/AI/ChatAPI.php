<?php

namespace App\AI;

use App\Core\Database;
use App\AI\AIConfig;
use PDO;
use PDOException;

/**
 * Chat API для работы с AI
 * Адаптировано под AI Agro Care
 */
class ChatAPI
{
    private Database $db;
    private PDO $pdo;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
    }

    /**
     * Отправка сообщения в AI и получение ответа
     */
    public function sendMessage(
        string $userId,
        string $message,
        string $contextType = 'general',
        ?string $contextId = null,
        array $contextData = [],
        ?string $imagePath = null
    ): array {
        try {
            // Сохраняем сообщение пользователя
            $this->saveMessage($userId, 'user', $message, $contextType, $contextId);

            // Получаем контекст (последние N сообщений)
            $context = $this->getContext($userId, $contextType, $contextId, AIConfig::MAX_CONTEXT_MESSAGES);
            $context = $this->removeDuplicateUserMessageFromContext($context, $message);

            // Получаем system prompt
            $systemPrompt = AIConfig::getSystemPrompt($contextType, $contextData);

            // Формируем запрос к AI
            $messages = [
                ['role' => 'system', 'content' => $systemPrompt]
            ];

            // Добавляем историю сообщений (без system, они уже есть)
            foreach ($context as $msg) {
                if ($msg['role'] !== 'system') {
                    $messages[] = [
                        'role' => $msg['role'],
                        'content' => $msg['content']
                    ];
                }
            }

            // Добавляем текущее сообщение пользователя (Multimodal if image exists)
            if ($imagePath && file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $mimeType = mime_content_type($imagePath);

                $messages[] = [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $message],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => "data:{$mimeType};base64,{$imageData}"
                            ]
                        ]
                    ]
                ];
            } else {
                $messages[] = [
                    'role' => 'user',
                    'content' => $message
                ];
            }

            // Отправляем запрос к Hugging Face
            $response = $this->callHuggingFaceAPI($messages);

            if ($response['success']) {
                $aiResponse = $response['content'];

                // Сохраняем ответ AI
                $this->saveMessage($userId, 'assistant', $aiResponse, $contextType, $contextId);

                return [
                    'success' => true,
                    'message' => $aiResponse,
                    'metadata' => $response['metadata'] ?? []
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $response['error'] ?? 'Ошибка при обращении к AI'
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Ошибка: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Сохранение сообщения в БД
     */
    private function saveMessage(
        string $userId,
        string $role,
        string $content,
        string $contextType = 'general',
        ?string $contextId = null
    ): void {
        $sql = "INSERT INTO ai_messages (user_id, context_type, context_id, role, content)
                VALUES (:user_id, :context_type, :context_id, :role, :content)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':context_type' => $contextType,
            ':context_id' => !empty($contextId) ? $contextId : null,
            ':role' => $role,
            ':content' => $content
        ]);
    }

    /**
     * Публичный метод для сохранения сообщения напрямую (для использования из контроллеров)
     */
    public function saveMessageDirectly(
        string $userId,
        string $role,
        string $content,
        string $contextType = 'general',
        ?string $contextId = null
    ): void {
        $this->saveMessage($userId, $role, $content, $contextType, $contextId);
    }

    /**
     * Получение контекста (истории сообщений)
     */
    private function getContext(
        string $userId,
        string $contextType,
        ?string $contextId,
        int $limit
    ): array {
        $sql = "SELECT role, content
                FROM ai_messages
                WHERE user_id = :user_id
                  AND context_type = :context_type
                  AND role != 'system'";

        $params = [
            ':user_id' => $userId,
            ':context_type' => $contextType
        ];

        if (!empty($contextId)) {
            $sql .= " AND context_id = :context_id";
            $params[':context_id'] = $contextId;
        } else {
            $sql .= " AND (context_id IS NULL OR context_id = '')";
        }

        $sql .= " ORDER BY created_at DESC LIMIT :limit";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Переворачиваем, чтобы старые сообщения были первыми
        return array_reverse($messages);
    }

    /**
     * Вызов Hugging Face Router API (OpenAI-совместимый формат)
     * Адаптировано из Safy AI (chat_api.php)
     * Улучшено для более качественных и естественных ответов
     */
    private function callHuggingFaceAPI(array $messages): array
    {
        $apiKey = AIConfig::getApiKey();
        $apiUrl = AIConfig::AI_API_URL;

        // Формируем запрос в OpenAI-совместимом формате (требуется для Router)
        $data = [
            'model' => AIConfig::AI_MODEL,
            'messages' => $messages,
            'temperature' => AIConfig::TEMPERATURE,
            'max_tokens' => AIConfig::MAX_TOKENS,
            'top_p' => 0.85
        ];

        [$response, $httpCode, $error] = $this->executeHfRequest($apiUrl, $apiKey, $data);

        if ($error) {
            return [
                'success' => false,
                'error' => 'CURL ошибка: ' . $error
            ];
        }

        if ($httpCode !== 200) {
            $errorMsg = "API Error: HTTP {$httpCode}";
            try {
                $errData = json_decode($response, true);
                if (isset($errData['error']['message'])) {
                    $errorMsg .= " - " . $errData['error']['message'];
                }
            } catch (\Exception $e) {
            }

            error_log("Hugging Face Router API Error: " . $errorMsg . " | Response: " . $response);
            return [
                'success' => false,
                'error' => $errorMsg
            ];
        }

        $responseData = json_decode($response, true);

        // Парсим ответ от Hugging Face Router (OpenAI-совместимый формат)
        if (isset($responseData['choices'][0]['message']['content'])) {
            $rawContent = trim($responseData['choices'][0]['message']['content']);
            $content = $rawContent;

            // КРИТИЧНО: Удаляем китайские иероглифы и символы (Hanzi/CJK Symbols)
            // Диапазон китайских иероглифов: \x{4E00}-\x{9FFF}
            // Пунктуация CJK: \x{3000}-\x{303F}
            // Полноширинные формы (full-width): \x{FF00}-\x{FFEF}
            $content = preg_replace('/[\x{4E00}-\x{9FFF}\x{3000}-\x{303F}\x{FF00}-\x{FFEF}]+/u', ' ', $content);

            // Также удаляем другие расширенные китайские/азиатские блоки
            $content = preg_replace('/[\x{3400}-\x{4DBF}\x{20000}-\x{2A6DF}\x{2A700}-\x{2B73F}\x{2B740}-\x{2B81F}\x{2B820}-\x{2CEAF}]+/u', '', $content);

            // Очистка ответа от артефактов (не вырезаем системный промпт целиком,
            // чтобы случайно не потерять валидный текст ответа)

            // Удаляем возможные метки ролей
            $content = preg_replace('/^(User|Assistant|System):\s*/mi', '', $content);
            $content = preg_replace('/<\|(user|assistant|system)\|>/i', '', $content);
            $content = preg_replace('/<\|endoftext\|>/i', '', $content);

            // Удаляем лишние пробелы и переносы
            $content = preg_replace('/\n{3,}/', "\n\n", $content);
            $content = trim($content);

            // Убираем технические structured-блоки для UI (если модель их вернула)
            $content = $this->stripStructuredBlocks($content);

            // Если после фильтрации осталось слишком мало текста, отдаём понятную ошибку
            if (mb_strlen($content) < 30) {
                $content = "Извините, произошла ошибка при обработке ответа AI. Пожалуйста, попробуйте переформулировать вопрос или обратитесь к специалисту.";
            }

            $finishReason = $responseData['choices'][0]['finish_reason'] ?? null;

            $guard = 0;
            while ($this->isTruncatedResponse($content, $finishReason) && $guard < 3) {
                $continued = $this->requestContinuation($messages, $content, $apiUrl, $apiKey);
                if ($continued === '') {
                    break;
                }
                $content = rtrim($content) . "\n" . ltrim($continued);
                $content = $this->stripStructuredBlocks($content);
                $finishReason = null;
                $guard++;
            }

            return [
                'success' => true,
                'content' => $content,
                'metadata' => [
                    'raw_content' => $rawContent,
                    'finish_reason' => $finishReason
                ]
            ];
        } else {
            error_log("Unexpected AI response format: " . substr($response, 0, 500));
            return [
                'success' => false,
                'error' => 'Неожиданный формат ответа от API. Проверьте логи.'
            ];
        }
    }

    /**
     * Обновление context_id для сообщений (используется когда context_id изначально NULL)
     * Например, когда сообщения сохраняются до создания плана/кейса
     */
    public function updateMessagesContextId(
        string $userId,
        string $contextType,
        string $contextId
    ): void {
        try {
            $sql = "UPDATE ai_messages
                    SET context_id = :context_id
                    WHERE user_id = :user_id
                      AND context_type = :context_type
                      AND context_id IS NULL
                      AND created_at > NOW() - INTERVAL 5 MINUTE";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':context_id' => $contextId,
                ':user_id' => $userId,
                ':context_type' => $contextType
            ]);

            $updatedCount = $stmt->rowCount();
            error_log("Updated $updatedCount messages with context_id=$contextId for context_type=$contextType");
        } catch (\Exception $e) {
            error_log("Failed to update messages context_id: " . $e->getMessage());
            // Не бросаем исключение, чтобы не прерывать основной процесс
        }
    }

    /**
     * Получение истории чата
     */
    public function getChatHistory(
        string $userId,
        string $contextType = 'general',
        ?string $contextId = null,
        int $limit = 50
    ): array {
        $sql = "SELECT id, role, content, created_at
                FROM ai_messages
                WHERE user_id = :user_id
                  AND context_type = :context_type";

        $params = [
            ':user_id' => $userId,
            ':context_type' => $contextType
        ];

        if ($contextId) {
            $sql .= " AND context_id = :context_id";
            $params[':context_id'] = $contextId;
        } else {
            $sql .= " AND (context_id IS NULL OR context_id = '')";
        }

        $sql .= " ORDER BY created_at ASC LIMIT :limit";

        try {
            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Логируем для отладки и проверяем длину контента
            foreach ($result as $msg) {
                $contentLength = strlen($msg['content'] ?? '');
                error_log("Message: role={$msg['role']}, content_length=$contentLength");
            }

            error_log("Chat history query: user_id=$userId, context_type=$contextType, context_id=" . ($contextId ?? 'NULL') . ", found " . count($result) . " messages");

            return $result;
        } catch (\Exception $e) {
            error_log("Error fetching chat history: " . $e->getMessage() . " | SQL: " . $sql);
            return [];
        }
    }

    /**
     * Получение списка уникальных сессий чата для пользователя
     */
    public function getChatSessions(string $userId): array
    {
        $sql = "SELECT 
                    context_type, 
                    context_id, 
                    MAX(created_at) as last_message_at,
                    (SELECT content FROM ai_messages m2 
                     WHERE m2.user_id = m1.user_id
                       AND m2.context_type = m1.context_type 
                       AND (m2.context_id = m1.context_id OR (m2.context_id IS NULL AND m1.context_id IS NULL))
                       AND m2.role = 'user' 
                     ORDER BY created_at ASC LIMIT 1) as title
                FROM ai_messages m1
                WHERE user_id = :user_id
                GROUP BY context_type, context_id, user_id
                ORDER BY last_message_at DESC";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log("Error fetching chat sessions: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Удаление сессии чата (всех сообщений в данном контексте)
     */
    public function deleteSession(string $userId, string $contextType, ?string $contextId): bool
    {
        try {
            if ($contextId) {
                $sql = "DELETE FROM ai_messages 
                        WHERE user_id = :user_id 
                          AND context_type = :context_type 
                          AND context_id = :context_id";
                $params = [
                    ':user_id' => $userId,
                    ':context_type' => $contextType,
                    ':context_id' => $contextId
                ];
            } else {
                $sql = "DELETE FROM ai_messages 
                        WHERE user_id = :user_id 
                          AND context_type = :context_type 
                          AND context_id IS NULL";
                $params = [
                    ':user_id' => $userId,
                    ':context_type' => $contextType
                ];
            }

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (\Exception $e) {
            error_log("Error deleting chat session: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Удаляет из контекста дублирующее текущее сообщение пользователя.
     * Это помогает модели не повторяться и отвечать точнее.
     */
    private function removeDuplicateUserMessageFromContext(array $context, string $currentMessage): array
    {
        if (empty($context)) {
            return $context;
        }

        $lastIdx = count($context) - 1;
        $last = $context[$lastIdx] ?? null;
        if (!is_array($last)) {
            return $context;
        }

        if (($last['role'] ?? '') === 'user') {
            $lastContent = trim((string) ($last['content'] ?? ''));
            if ($lastContent !== '' && $lastContent === trim($currentMessage)) {
                array_pop($context);
            }
        }

        return $context;
    }

    /**
     * Скрывает технические блоки, которые нужны только системе,
     * но не должны показываться пользователю в чате.
     */
    private function stripStructuredBlocks(string $text): string
    {
        if ($text === '') {
            return $text;
        }

        // Основной блок для структурированного JSON
        $text = preg_replace('/START_PLAN_JSON\s*\{.*?\}\s*END_PLAN_JSON/si', '', $text);
        // Запасной вариант с любыми маркерами START_/END_
        $text = preg_replace('/START_[A-Z_]+\s*.*?\s*END_[A-Z_]+/si', '', $text);
        // Убираем лишние пустые строки после удаления блоков
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    private function executeHfRequest(string $apiUrl, string $apiKey, array $data): array
    {
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, AIConfig::REQUEST_TIMEOUT);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return [$response, $httpCode, $error];
    }

    private function isTruncatedResponse(string $content, ?string $finishReason): bool
    {
        if ($finishReason === 'length') {
            return true;
        }

        $trimmed = trim($content);
        if ($trimmed === '') {
            return false;
        }

        // Частые признаки обрыва ответа
        if (preg_match('/[:;\-–—]$/u', $trimmed)) {
            return true;
        }
        if (preg_match('/\b[А-Яа-яA-Za-z]{1,2}$/u', $trimmed)) {
            return true;
        }
        if (preg_match('/(^|\n)\s*\d+\.\s+[^\n:]{1,120}:\s*$/u', $trimmed)) {
            return true;
        }
        if (preg_match('/(^|\n)\s*[-•]\s*[^\n]{0,2}$/u', $trimmed)) {
            return true;
        }
        if (substr($trimmed, -1) !== '.' && substr($trimmed, -1) !== '!' && substr($trimmed, -1) !== '?') {
            // Для структурированных ответов без точки в конце иногда это нормально,
            // но лучше сделать одну попытку продолжения.
            return true;
        }

        return false;
    }

    private function requestContinuation(array $messages, string $partialContent, string $apiUrl, string $apiKey): string
    {
        $tail = mb_substr($partialContent, -1800);
        $continuationMessages = [
            [
                'role' => 'system',
                'content' => "Ты дописываешь уже начатый профессиональный ответ. Нельзя повторять ранее написанное. Нельзя начинать заново. Нужно закончить оставшиеся пункты четко и кратко."
            ],
            [
                'role' => 'user',
                'content' => "Вот конец уже выданного ответа:\n\n" . $tail . "\n\nПродолжи строго с места обрыва. Дополни недостающие подпункты и завершай ответ финальной строкой 'Готово.'."
            ]
        ];

        $continuationData = [
            'model' => AIConfig::AI_MODEL,
            'messages' => $continuationMessages,
            'temperature' => AIConfig::TEMPERATURE,
            'max_tokens' => 900,
            'top_p' => 0.85
        ];

        [$response, $httpCode, $error] = $this->executeHfRequest($apiUrl, $apiKey, $continuationData);
        if ($error || $httpCode !== 200) {
            return '';
        }

        $responseData = json_decode((string) $response, true);
        $cont = $responseData['choices'][0]['message']['content'] ?? '';
        if (!is_string($cont) || trim($cont) === '') {
            return '';
        }

        $cont = $this->stripStructuredBlocks(trim($cont));
        if (mb_strlen($cont) < 8) {
            return '';
        }

        return $cont;
    }
}
