<?php

namespace App\Core;

use App\Core\Database;
use PDO;

class Auth
{
    private Database $db;
    private PDO $pdo;
    private Session $session;

    public function __construct()
    {
        $this->db = new Database();
        $this->pdo = $this->db->getConnection();
        $this->session = new Session();
    }

    /**
     * Регистрация пользователя
     */
    public function register(string $email, string $phone, string $password, string $role = 'farmer', ?string $vetPhone = null): array
    {
        // Валидация
        if (empty($email) && empty($phone)) {
            return ['success' => false, 'error' => 'Email или телефон обязательны'];
        }

        if (empty($password) || strlen($password) < 6) {
            return ['success' => false, 'error' => 'Пароль должен быть не менее 6 символов'];
        }

        // Проверка существования
        if (!empty($email)) {
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                return ['success' => false, 'error' => 'Email уже зарегистрирован'];
            }
        }

        if (!empty($phone)) {
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE phone = :phone");
            $stmt->execute([':phone' => $phone]);
            if ($stmt->fetch()) {
                return ['success' => false, 'error' => 'Телефон уже зарегистрирован'];
            }
        }

        // Создание пользователя
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Для ветеринаров сохраняем номер телефона в notification_settings (если колонка есть)
        $hasNotificationSettings = $this->hasColumn('users', 'notification_settings');

        if ($hasNotificationSettings) {
            $notificationSettings = '{}';
            if ($role === 'veterinarian' && $vetPhone) {
                $notificationSettings = json_encode(['vet_phone' => $vetPhone]);
            }

            $sql = "INSERT INTO users (email, phone, password_hash, role, notification_settings)
                    VALUES (:email, :phone, :password_hash, :role, :notification_settings)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':email' => $email ?: null,
                ':phone' => $phone ?: null,
                ':password_hash' => $passwordHash,
                ':role' => $role,
                ':notification_settings' => $notificationSettings
            ]);
        } else {
            $sql = "INSERT INTO users (email, phone, password_hash, role)
                    VALUES (:email, :phone, :password_hash, :role)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':email' => $email ?: null,
                ':phone' => $phone ?: null,
                ':password_hash' => $passwordHash,
                ':role' => $role
            ]);
        }

        $userId = $this->pdo->lastInsertId();

        if ($userId) {
            $this->loginById($userId);
            return ['success' => true, 'user_id' => $userId];
        }

        return ['success' => false, 'error' => 'Ошибка при регистрации'];
    }

    /**
     * Вход пользователя
     */
    public function login(string $emailOrPhone, string $password): array
    {
        $sql = "SELECT id, email, phone, password_hash, role, is_active
                FROM users
                WHERE (email = :identifier OR phone = :identifier)
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':identifier' => $emailOrPhone]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['success' => false, 'error' => 'Пользователь не найден'];
        }

        if (!$user['is_active']) {
            return ['success' => false, 'error' => 'Аккаунт заблокирован'];
        }

        if (!password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'error' => 'Неверный пароль'];
        }

        $this->loginById($user['id']);

        return [
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => $user['role']
            ]
        ];
    }

    /**
     * Вход по ID
     */
    private function loginById(string $userId): void
    {
        $this->session->set('user_id', $userId);
        $this->session->set('logged_in', true);
    }

    /**
     * Выход
     */
    public function logout(): void
    {
        $this->session->remove('user_id');
        $this->session->remove('logged_in');
    }

    /**
     * Проверка авторизации
     */
    public function check(): bool
    {
        return $this->session->has('logged_in') && $this->session->has('user_id');
    }

    /**
     * Получение текущего пользователя
     */
    public function user(): ?array
    {
        if (!$this->check()) {
            return null;
        }

        $userId = $this->session->get('user_id');

        $sql = "SELECT id, email, phone, role, language, timezone, created_at
                FROM users
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Получение ID текущего пользователя
     */
    public function userId(): ?string
    {
        return $this->session->get('user_id');
    }

    /**
     * Проверка существования колонки в таблице
     */
    private function hasColumn(string $table, string $column): bool
    {
        try {
            $sql = "SELECT column_name
                    FROM information_schema.columns
                    WHERE table_name = :table AND column_name = :column";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':table' => $table, ':column' => $column]);
            return (bool) $stmt->fetch();
        } catch (\Exception $e) {
            return false;
        }
    }
}
