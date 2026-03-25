<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class CropCycleController
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
     * Получение истории посевов участка
     */
    public function index(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $fieldId = $body['field_id'] ?? '';

        if (empty($fieldId)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'field_id обязателен']);
        }

        $userId = $this->auth->userId();

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

        $sql = "SELECT * FROM crop_cycles
                WHERE field_id = :field_id
                ORDER BY year DESC, created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':field_id' => $fieldId]);
        $cycles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return json_encode(['success' => true, 'cycles' => $cycles]);
    }

    /**
     * Создание записи о посеве
     */
    public function create(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $fieldId = $body['field_id'] ?? '';
        $crop = $body['crop'] ?? '';
        $year = $body['year'] ?? (int) date('Y');
        $yield = $body['yield'] ?? null;
        $notes = $body['notes'] ?? null;

        if (empty($fieldId) || empty($crop)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'field_id и crop обязательны']);
        }

        $userId = $this->auth->userId();

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

        $sql = "INSERT INTO crop_cycles (field_id, crop, year, yield, notes)
                VALUES (:field_id, :crop, :year, :yield, :notes)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':field_id' => $fieldId,
            ':crop' => $crop,
            ':year' => $year,
            ':yield' => $yield,
            ':notes' => $notes
        ]);

        $cycleId = $this->pdo->lastInsertId();

        return json_encode(['success' => true, 'cycle_id' => $cycleId]);
    }
}
