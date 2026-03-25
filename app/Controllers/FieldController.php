<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class FieldController
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
     * Список участков хозяйства
     */
    public function index(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $farmId = $body['farm_id'] ?? $request->getBody()['farm_id'] ?? '';

        if (empty($farmId)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'farm_id обязателен']);
        }

        $userId = $this->auth->userId();

        // Проверяем доступ к хозяйству
        $sql = "SELECT 1 FROM user_farms WHERE farm_id = :farm_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':farm_id' => $farmId, ':user_id' => $userId]);

        if (!$stmt->fetch()) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Нет доступа к хозяйству']);
        }

        $sql = "SELECT * FROM fields WHERE farm_id = :farm_id ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':farm_id' => $farmId]);
        $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode(['success' => true, 'fields' => $fields]);
    }

    /**
     * Создание участка
     */
    public function create(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $farmId = $body['farm_id'] ?? '';
        $name = $body['name'] ?? '';
        $areaHectares = isset($body['area_hectares']) ? (float) $body['area_hectares'] : null;
        $currentCrop = $body['current_crop'] ?? null;
        $geometry = $body['geometry'] ?? null;

        if (empty($farmId) || empty($name)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'farm_id и name обязательны']);
        }

        // farm_id validation
        if (!is_numeric($farmId)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Неверный ID хозяйства']);
        }

        $userId = $this->auth->userId();

        // Проверяем доступ
        $sql = "SELECT 1 FROM user_farms WHERE farm_id = :farm_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':farm_id' => $farmId, ':user_id' => $userId]);

        if (!$stmt->fetch()) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Нет доступа к хозяйству']);
        }

        // Преобразуем geometry в JSON строку, если это массив/объект
        $geometryJson = null;
        if ($geometry !== null) {
            if (is_array($geometry) || is_object($geometry)) {
                $geometryJson = json_encode($geometry, JSON_UNESCAPED_UNICODE);
            } else {
                $geometryJson = $geometry; // Уже строка
            }
        }

        try {
            $sql = "INSERT INTO fields (farm_id, name, area_ha, current_crop, coordinates)
                    VALUES (:farm_id, :name, :area_ha, :current_crop, :geometry)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':farm_id' => $farmId,
                ':name' => $name,
                ':area_ha' => $areaHectares,
                ':current_crop' => $currentCrop,
                ':geometry' => $geometryJson
            ]);

            $fieldId = $this->pdo->lastInsertId();

            if (!$fieldId) {
                throw new \Exception('Не удалось создать участок');
            }

            return json_encode(['success' => true, 'field_id' => $fieldId]);
        } catch (\PDOException $e) {
            error_log("Database error creating field: " . $e->getMessage());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка базы данных: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            error_log("Error creating field: " . $e->getMessage());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка при создании участка: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Получение участка
     */
    public function show(Request $request, ?string $id = null): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();

        $sql = "SELECT f.* FROM fields f
                INNER JOIN farms fa ON f.farm_id = fa.id
                INNER JOIN user_farms uf ON fa.id = uf.farm_id
                WHERE f.id = :id AND uf.user_id = :user_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $field = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$field) {
            http_response_code(404);
            return json_encode(['success' => false, 'error' => 'Участок не найден']);
        }

        return json_encode(['success' => true, 'field' => $field]);
    }

    /**
     * Обновление участка
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

        // Проверяем доступ
        $sql = "SELECT 1 FROM fields f
                INNER JOIN farms fa ON f.farm_id = fa.id
                INNER JOIN user_farms uf ON fa.id = uf.farm_id
                WHERE f.id = :id AND uf.user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':user_id' => $userId]);

        if (!$stmt->fetch()) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Нет доступа']);
        }

        $updates = [];
        $params = [':id' => $id];

        if (isset($body['name'])) {
            $updates[] = 'name = :name';
            $params[':name'] = $body['name'];
        }
        if (isset($body['area_ha'])) {
            $updates[] = 'area_ha = :area_ha';
            $params[':area_ha'] = $body['area_ha'];
        }
        if (isset($body['current_crop'])) {
            $updates[] = 'current_crop = :current_crop';
            $params[':current_crop'] = $body['current_crop'];
        }

        if (empty($updates)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Нет данных для обновления']);
        }

        $updates[] = 'updated_at = CURRENT_TIMESTAMP';

        $sql = "UPDATE fields SET " . implode(', ', $updates) . " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return json_encode(['success' => true]);
    }

    /**
     * Удаление участка
     */
    public function delete(Request $request, ?string $id = null): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();

        // Проверяем доступ
        $sql = "SELECT 1 FROM fields f
                INNER JOIN farms fa ON f.farm_id = fa.id
                INNER JOIN user_farms uf ON fa.id = uf.farm_id
                WHERE f.id = :id AND uf.user_id = :user_id AND uf.role IN ('owner', 'manager')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id, ':user_id' => $userId]);

        if (!$stmt->fetch()) {
            http_response_code(403);
            return json_encode(['success' => false, 'error' => 'Нет прав для удаления']);
        }

        $sql = "DELETE FROM fields WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return json_encode(['success' => true]);
    }
}
