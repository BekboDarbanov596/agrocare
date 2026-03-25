<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class FarmController
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
     * Список хозяйств пользователя
     */
    public function index(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();

        $sql = "SELECT f.*, uf.role as user_role
                FROM farms f
                INNER JOIN user_farms uf ON f.id = uf.farm_id
                WHERE uf.user_id = :user_id
                ORDER BY f.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $farms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode(['success' => true, 'farms' => $farms]);
    }

    /**
     * Создание хозяйства
     */
    public function create(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $name = $body['name'] ?? '';
        $region = $body['region'] ?? '';
        $address = $body['address'] ?? '';

        if (empty($name)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Название обязательно']);
        }

        $userId = $this->auth->userId();

        $this->pdo->beginTransaction();

        try {
            // Создаем хозяйство
            $sql = "INSERT INTO farms (name, region, address, owner_id)
                    VALUES (:name, :region, :address, :owner_id)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':region' => $region ?: null,
                ':address' => $address ?: null,
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

            return json_encode(['success' => true, 'farm_id' => $farmId]);

        } catch (\Exception $e) {
            $this->pdo->rollBack();
            http_response_code(500);
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Получение хозяйства
     */
    public function show(Request $request, ?string $id = null): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();

        $sql = "SELECT f.*, uf.role as user_role
                FROM farms f
                INNER JOIN user_farms uf ON f.id = uf.farm_id
                WHERE f.id = :id AND uf.user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $farm = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$farm) {
            http_response_code(404);
            return json_encode(['success' => false, 'error' => 'Хозяйство не найдено']);
        }

        return json_encode(['success' => true, 'farm' => $farm]);
    }

    /**
     * Обновление хозяйства
     */
    public function update(Request $request, ?string $id = null): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $userId = $this->auth->userId();

        // Проверяем права
        $sql = "SELECT uf.role FROM user_farms uf
                WHERE uf.farm_id = :id AND uf.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $userRole = $stmt->fetchColumn();

        if (!$userRole || !in_array($userRole, ['owner', 'manager'])) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Нет прав для редактирования']);
        }

        $updates = [];
        $params = [':id' => $id];

        if (isset($body['name'])) {
            $updates[] = 'name = :name';
            $params[':name'] = $body['name'];
        }
        if (isset($body['region'])) {
            $updates[] = 'region = :region';
            $params[':region'] = $body['region'];
        }
        if (isset($body['address'])) {
            $updates[] = 'address = :address';
            $params[':address'] = $body['address'];
        }

        if (empty($updates)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Нет данных для обновления']);
        }

        $updates[] = 'updated_at = CURRENT_TIMESTAMP';

        $sql = "UPDATE farms SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return json_encode(['success' => true]);
    }

    /**
     * Удаление хозяйства
     */
    public function delete(Request $request, ?string $id = null): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();

        // Проверяем, что пользователь - владелец
        $sql = "SELECT owner_id FROM farms WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $ownerId = $stmt->fetchColumn();

        if ($ownerId !== $userId) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Только владелец может удалить хозяйство']);
        }

        $sql = "DELETE FROM farms WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return json_encode(['success' => true]);
    }
}
