<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class VetProfileController
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
     * Получение или создание профиля ветеринара
     */
    public function getOrCreate(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
        }

        $userId = $this->auth->userId();

        // Проверяем роль
        $user = $this->auth->user();
        if ($user['role'] !== 'veterinarian') {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Только для ветеринаров'], JSON_UNESCAPED_UNICODE);
        }

        // Ищем существующий профиль
        $sql = "SELECT * FROM vet_profiles WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            // Создаем пустой профиль
            $sql = "INSERT INTO vet_profiles (user_id) VALUES (:user_id)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);

            // Получаем только что созданный профиль
            $sql = "SELECT * FROM vet_profiles WHERE user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Преобразуем JSON поля в PHP массивы
        if (isset($profile['specialization']) && is_string($profile['specialization'])) {
            $profile['specialization'] = json_decode($profile['specialization'], true) ?: [];
        } elseif (!isset($profile['specialization']) || !is_array($profile['specialization'])) {
            $profile['specialization'] = [];
        }

        if (isset($profile['certifications']) && is_string($profile['certifications'])) {
            $profile['certifications'] = json_decode($profile['certifications'], true) ?: [];
        } elseif (!isset($profile['certifications']) || !is_array($profile['certifications'])) {
            $profile['certifications'] = [];
        }

        if (isset($profile['languages']) && is_string($profile['languages'])) {
            $profile['languages'] = json_decode($profile['languages'], true) ?: ['ru'];
        } elseif (!isset($profile['languages']) || !is_array($profile['languages'])) {
            $profile['languages'] = ['ru'];
        }

        if (isset($profile['available_hours']) && is_string($profile['available_hours'])) {
            $profile['available_hours'] = json_decode($profile['available_hours'], true) ?: [];
        }

        return json_encode(['success' => true, 'profile' => $profile], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Обновление профиля ветеринара
     */
    public function update(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
        }

        $userId = $this->auth->userId();
        $user = $this->auth->user();
        if ($user['role'] !== 'veterinarian') {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Только для ветеринаров'], JSON_UNESCAPED_UNICODE);
        }

        $body = $request->getBody();

        // Подготавливаем данные для обновления
        $updateFields = [];
        $params = [':user_id' => $userId];

        $allowedFields = [
            'full_name',
            'experience_years',
            'education',
            'bio',
            'consultation_price',
            'photo_uri',
            'is_available'
        ];

        foreach ($allowedFields as $field) {
            if (isset($body[$field])) {
                $updateFields[] = "$field = :$field";
                $params[":$field"] = $body[$field];
            }
        }

        // Обработка JSON полей
        if (isset($body['specialization']) && is_array($body['specialization'])) {
            $updateFields[] = "specialization = :specialization";
            $params[':specialization'] = json_encode($body['specialization'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($body['certifications']) && is_array($body['certifications'])) {
            $updateFields[] = "certifications = :certifications";
            $params[':certifications'] = json_encode($body['certifications'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($body['languages']) && is_array($body['languages'])) {
            $updateFields[] = "languages = :languages";
            $params[':languages'] = json_encode($body['languages'], JSON_UNESCAPED_UNICODE);
        }

        if (isset($body['available_hours']) && is_array($body['available_hours'])) {
            $updateFields[] = "available_hours = :available_hours";
            $params[':available_hours'] = json_encode($body['available_hours'], JSON_UNESCAPED_UNICODE);
        }

        if (empty($updateFields)) {
            return json_encode(['success' => false, 'error' => 'Нет данных для обновления'], JSON_UNESCAPED_UNICODE);
        }

        $updateFields[] = "updated_at = CURRENT_TIMESTAMP";

        $sql = "UPDATE vet_profiles SET " . implode(', ', $updateFields) . " WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        // Получаем обновленный профиль
        $sql = "SELECT * FROM vet_profiles WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profile) {
            http_response_code(404);
            return json_encode(['success' => false, 'error' => 'Профиль не найден'], JSON_UNESCAPED_UNICODE);
        }

        // Преобразуем массивы PostgreSQL в PHP массивы
        if (isset($profile['specialization'])) {
            if (is_string($profile['specialization']) && strpos($profile['specialization'], '{') === 0) {
                $profile['specialization'] = array_filter(
                    array_map('trim', explode(',', trim($profile['specialization'], '{}')))
                );
            } elseif (!is_array($profile['specialization'])) {
                $profile['specialization'] = [];
            }
        }

        if (isset($profile['certifications'])) {
            if (is_string($profile['certifications']) && strpos($profile['certifications'], '{') === 0) {
                $profile['certifications'] = array_filter(
                    array_map('trim', explode(',', trim($profile['certifications'], '{}')))
                );
            } elseif (!is_array($profile['certifications'])) {
                $profile['certifications'] = [];
            }
        }

        if (isset($profile['languages'])) {
            if (is_string($profile['languages']) && strpos($profile['languages'], '{') === 0) {
                $profile['languages'] = array_filter(
                    array_map('trim', explode(',', trim($profile['languages'], '{}')))
                );
            } elseif (!is_array($profile['languages'])) {
                $profile['languages'] = ['ru'];
            }
        }

        if (isset($profile['available_hours']) && is_string($profile['available_hours'])) {
            $profile['available_hours'] = json_decode($profile['available_hours'], true) ?: [];
        }

        return json_encode(['success' => true, 'profile' => $profile], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Список всех ветеринаров
     */
    public function list(Request $request): string
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
            $sql = "SELECT
                        vp.*,
                        u.phone,
                        u.email,
                        u.created_at as user_created_at
                    FROM vet_profiles vp
                    JOIN users u ON vp.user_id = u.id
                    WHERE u.role = 'veterinarian'
                      AND u.is_active = true
                      AND (vp.is_available IS NULL OR vp.is_available = true)
                    ORDER BY vp.rating DESC, vp.total_consultations DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $vets = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($vets as &$vet) {
                // JSON поля обрабатываем через json_decode
                if (isset($vet['specialization']) && is_string($vet['specialization'])) {
                    $vet['specialization'] = json_decode($vet['specialization'], true) ?: [];
                }
                if (isset($vet['certifications']) && is_string($vet['certifications'])) {
                    $vet['certifications'] = json_decode($vet['certifications'], true) ?: [];
                }
                if (isset($vet['languages']) && is_string($vet['languages'])) {
                    $vet['languages'] = json_decode($vet['languages'], true) ?: ['ru'];
                }

                if (isset($vet['available_hours']) && is_string($vet['available_hours'])) {
                    $vet['available_hours'] = json_decode($vet['available_hours'], true) ?: [];
                }
            }
            unset($vet);

            return json_encode(['success' => true, 'veterinarians' => $vets], JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);

        } catch (\Exception $e) {
            error_log("Error in VetProfileController::list: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка загрузки ветеринаров: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
