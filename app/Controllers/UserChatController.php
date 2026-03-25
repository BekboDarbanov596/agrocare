<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class UserChatController
{
    private Database $db;
    private PDO $pdo;
    private Auth $auth;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
        $this->auth = new Auth();
    }

    /**
     * Получение или создание чата с пользователем
     */
    public function getOrCreateChat(Request $request, string $otherUserId = null): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
        }

        // Если userId не передан в параметрах, берем из body
        if (!$otherUserId) {
            $body = $request->getBody();
            $otherUserId = $body['user_id'] ?? null;
        }

        if (!$otherUserId) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'user_id обязателен'], JSON_UNESCAPED_UNICODE);
        }

        $currentUserId = $this->auth->userId();

        if ($currentUserId === $otherUserId) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Нельзя создать чат с самим собой'], JSON_UNESCAPED_UNICODE);
        }

        // Ищем существующий чат
        $sql = "SELECT * FROM user_chats
                WHERE (user1_id = :user1_a AND user2_id = :user2_a)
                   OR (user1_id = :user2_b AND user2_id = :user1_b)
                LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user1_a' => $currentUserId,
            ':user1_b' => $currentUserId,
            ':user2_a' => $otherUserId,
            ':user2_b' => $otherUserId
        ]);
        $chat = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$chat) {
            // Создаем новый чат (user1_id всегда меньше user2_id для консистентности)
            $user1Id = $currentUserId < $otherUserId ? $currentUserId : $otherUserId;
            $user2Id = $currentUserId < $otherUserId ? $otherUserId : $currentUserId;

            $sql = "INSERT INTO user_chats (user1_id, user2_id)
                    VALUES (:user1, :user2)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':user1' => $user1Id,
                ':user2' => $user2Id
            ]);

            // Получаем созданный чат
            $sql = "SELECT * FROM user_chats WHERE user1_id = :user1 AND user2_id = :user2";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user1' => $user1Id, ':user2' => $user2Id]);
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Получаем информацию о собеседнике
        $otherId = $chat['user1_id'] === $currentUserId ? $chat['user2_id'] : $chat['user1_id'];
        $sql = "SELECT id, phone, email, role FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $otherId]);
        $otherUser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Если собеседник ветеринар, получаем его профиль
        if ($otherUser['role'] === 'veterinarian') {
            $sql = "SELECT full_name, photo_uri, specialization FROM vet_profiles WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $otherId]);
            $vetProfile = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($vetProfile) {
                $otherUser['vet_profile'] = $vetProfile;
            }
        }

        return json_encode([
            'success' => true,
            'chat' => $chat,
            'other_user' => $otherUser
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Отправка сообщения
     */
    public function sendMessage(Request $request): string
    {
        // Очищаем буфер вывода
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Устанавливаем заголовки
        if (!headers_sent()) {
            header('Content-Type: application/json; charset=utf-8');
            header('X-Content-Type-Options: nosniff');
        }

        try {
            if (!$this->auth->check()) {
                http_response_code(401);
                return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
            }

            $body = $request->getBody();
            $chatId = $body['chat_id'] ?? '';
            $content = trim($body['content'] ?? '');

            if (empty($chatId)) {
                http_response_code(400);
                return json_encode(['success' => false, 'error' => 'chat_id обязателен'], JSON_UNESCAPED_UNICODE);
            }

            if (empty($content)) {
                http_response_code(400);
                return json_encode(['success' => false, 'error' => 'Сообщение не может быть пустым'], JSON_UNESCAPED_UNICODE);
            }

            $senderId = $this->auth->userId();

            // Проверяем, что пользователь участвует в чате
            $sql = "SELECT * FROM user_chats WHERE id = :chat_id AND (user1_id = :user_id_1 OR user2_id = :user_id_2)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':chat_id' => $chatId,
                ':user_id_1' => $senderId,
                ':user_id_2' => $senderId
            ]);
            $chat = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$chat) {
                http_response_code(403);
                return json_encode(['success' => false, 'error' => 'Чат не найден'], JSON_UNESCAPED_UNICODE);
            }

            // Сохраняем сообщение
            $sql = "INSERT INTO user_messages (chat_id, sender_id, content)
                    VALUES (:chat_id, :sender_id, :content)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':chat_id' => $chatId,
                ':sender_id' => $senderId,
                ':content' => $content
            ]);
            $messageId = $this->pdo->lastInsertId();

            // Получаем сообщение
            $sql = "SELECT * FROM user_messages WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $messageId]);
            $message = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$message) {
                error_log("Failed to create message: chat_id=$chatId, sender_id=$senderId");
                http_response_code(500);
                return json_encode(['success' => false, 'error' => 'Ошибка сохранения сообщения'], JSON_UNESCAPED_UNICODE);
            }

            // Обновляем чат
            $isUser1 = $chat['user1_id'] === $senderId;
            $unreadField = $isUser1 ? 'unread_count_user2' : 'unread_count_user1';

            $sql = "UPDATE user_chats
                    SET last_message_at = CURRENT_TIMESTAMP,
                        last_message_text = :text,
                        $unreadField = $unreadField + 1,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :chat_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':chat_id' => $chatId,
                ':text' => mb_substr($content, 0, 100)
            ]);

            return json_encode(['success' => true, 'message' => $message], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            error_log("Error in UserChatController::sendMessage: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка отправки сообщения: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Получение истории сообщений
     */
    public function getMessages(Request $request, string $chatId): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
        }

        $userId = $this->auth->userId();

        // Проверяем доступ к чату
        $sql = "SELECT * FROM user_chats WHERE id = :chat_id AND (user1_id = :user_id_1 OR user2_id = :user_id_2)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':chat_id' => $chatId, ':user_id_1' => $userId, ':user_id_2' => $userId]);
        $chat = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$chat) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Чат не найден'], JSON_UNESCAPED_UNICODE);
        }

        // Получаем сообщения
        $sql = "SELECT * FROM user_messages
                WHERE chat_id = :chat_id
                ORDER BY created_at ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':chat_id' => $chatId]);
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Отмечаем сообщения как прочитанные
        $isUser1 = $chat['user1_id'] === $userId;
        $unreadField = $isUser1 ? 'unread_count_user1' : 'unread_count_user2';

        $sql = "UPDATE user_chats SET $unreadField = 0 WHERE id = :chat_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':chat_id' => $chatId]);

        // Отмечаем сообщения как прочитанные
        $sql = "UPDATE user_messages SET is_read = true
                WHERE chat_id = :chat_id AND sender_id != :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':chat_id' => $chatId, ':user_id' => $userId]);

        return json_encode(['success' => true, 'messages' => $messages], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Список чатов пользователя
     */
    public function getChats(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
        }

        $userId = $this->auth->userId();

        $sql = "SELECT
                    uc.*,
                    CASE
                        WHEN uc.user1_id = :user_id_1 THEN uc.user2_id
                        ELSE uc.user1_id
                    END as other_user_id
                FROM user_chats uc
                WHERE uc.user1_id = :user_id_2 OR uc.user2_id = :user_id_3
                ORDER BY uc.last_message_at IS NULL, uc.last_message_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':user_id_1' => $userId,
            ':user_id_2' => $userId,
            ':user_id_3' => $userId
        ]);
        $chats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Получаем информацию о собеседниках
        foreach ($chats as &$chat) {
            $otherId = $chat['other_user_id'];
            $sql = "SELECT id, phone, email, role FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $otherId]);
            $otherUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($otherUser['role'] === 'veterinarian') {
                $sql = "SELECT full_name, photo_uri, specialization FROM vet_profiles WHERE user_id = :user_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([':user_id' => $otherId]);
                $vetProfile = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($vetProfile) {
                    $otherUser['vet_profile'] = $vetProfile;
                }
            }

            $chat['other_user'] = $otherUser;
            $chat['unread_count'] = $chat['user1_id'] === $userId
                ? $chat['unread_count_user1']
                : $chat['unread_count_user2'];
        }
        unset($chat);

        return json_encode(['success' => true, 'chats' => $chats], JSON_UNESCAPED_UNICODE);
    }
}
