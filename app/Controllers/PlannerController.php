<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use PDO;

class PlannerController
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
     * Отображение страницы планировщика
     */
    public function view(Request $request): string
    {
        $GLOBALS['page_title'] = 'Планировщик - AI Agro Care';
        
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/planner.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Получение всех задач (ручных и автоматических)
     */
    public function index(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();
        
        try {
            // 1. Получаем ручные задачи
            $sqlManual = "SELECT * FROM planner_tasks WHERE user_id = :user_id ORDER BY task_date ASC";
            $stmtManual = $this->pdo->prepare($sqlManual);
            $stmtManual->execute([':user_id' => $userId]);
            $manualTasks = $stmtManual->fetchAll(PDO::FETCH_ASSOC);

            // 2. Получаем задачи из планов (поле plan_data -> tasks)
            $sqlPlans = "SELECT fp.id, fp.crop, fp.plan_data 
                        FROM field_plans fp 
                        WHERE fp.created_by = :user_id";
            $stmtPlans = $this->pdo->prepare($sqlPlans);
            $stmtPlans->execute([':user_id' => $userId]);
            $plans = $stmtPlans->fetchAll(PDO::FETCH_ASSOC);

            $autoTasks = [];
            foreach ($plans as $plan) {
                $data = json_decode($plan['plan_data'], true);
                if (isset($data['tasks']) && is_array($data['tasks'])) {
                    foreach ($data['tasks'] as $t) {
                        $autoTasks[] = [
                            'id' => 'p_' . $plan['id'] . '_' . md5($t['title']),
                            'title' => $t['title'] . ' (Посев: ' . $plan['crop'] . ')',
                            'description' => 'Автоматическая задача из плана по сере для ' . $plan['crop'],
                            'task_date' => $t['due_date'],
                            'task_type' => 'plan_event',
                            'status' => 'pending'
                        ];
                    }
                }
            }

            // 3. Получаем задачи из осмотров животных
            $sqlAnimals = "SELECT id, species, triage_level, created_at 
                          FROM animal_cases 
                          WHERE user_id = :user_id";
            $stmtAnimals = $this->pdo->prepare($sqlAnimals);
            $stmtAnimals->execute([':user_id' => $userId]);
            $animalCases = $stmtAnimals->fetchAll(PDO::FETCH_ASSOC);

            foreach ($animalCases as $case) {
                if ($case['triage_level'] === 'critical' || $case['triage_level'] === 'medium') {
                    // Создаем задачу на повторный осмотр через 3 дня
                    $followUpDate = date('Y-m-d', strtotime($case['created_at'] . ' +3 days'));
                    $autoTasks[] = [
                        'id' => 'a_' . $case['id'],
                        'title' => 'Повторный осмотр: ' . $case['species'],
                        'description' => 'Контроль состояния после диагностики (Уровень: ' . $case['triage_level'] . ')',
                        'task_date' => $followUpDate,
                        'task_type' => 'vet_visit',
                        'status' => 'pending'
                    ];
                }
            }

            // 4. Получаем задачи из анализа растений
            $sqlPlantAnalyses = "SELECT id, crop, recommendations, created_at 
                                FROM plant_analyses 
                                WHERE user_id = :user_id";
            $stmtPlantAnalyses = $this->pdo->prepare($sqlPlantAnalyses);
            $stmtPlantAnalyses->execute([':user_id' => $userId]);
            $plantAnalyses = $stmtPlantAnalyses->fetchAll(PDO::FETCH_ASSOC);

            foreach ($plantAnalyses as $analysis) {
                $recom = json_decode($analysis['recommendations'], true);
                if (isset($recom['urgent_actions']) && is_array($recom['urgent_actions'])) {
                    foreach ($recom['urgent_actions'] as $act) {
                        $autoTasks[] = [
                            'id' => 'pa_' . $analysis['id'] . '_' . md5($act),
                            'title' => $act . ' (' . $analysis['crop'] . ')',
                            'description' => 'Рекомендация по результатам AI фото-анализа',
                            'task_date' => date('Y-m-d', strtotime($analysis['created_at'])),
                            'task_type' => 'treatment',
                            'status' => 'pending'
                        ];
                    }
                }
            }

            return json_encode([
                'success' => true,
                'manual_tasks' => $manualTasks,
                'auto_tasks' => $autoTasks
            ]);

        } catch (\Exception $e) {
            http_response_code(500);
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Создание новой задачи
     */
    public function create(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $userId = $this->auth->userId();
        $title = $body['title'] ?? '';
        $date = $body['task_date'] ?? '';
        $desc = $body['description'] ?? '';

        if (empty($title) || empty($date)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Заполните заголовок и дату']);
        }

        try {
            $sql = "INSERT INTO planner_tasks (user_id, title, description, task_date) 
                    VALUES (:user_id, :title, :description, :task_date)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':user_id' => $userId,
                ':title' => $title,
                ':description' => $desc,
                ':task_date' => $date
            ]);

            return json_encode(['success' => true, 'id' => $this->pdo->lastInsertId()]);
        } catch (\Exception $e) {
            http_response_code(500);
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Удаление ручной задачи
     */
    public function delete(Request $request, array $params): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $taskId = $params['id'] ?? '';
        $userId = $this->auth->userId();

        try {
            $sql = "DELETE FROM planner_tasks WHERE id = :id AND user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $taskId, ':user_id' => $userId]);

            return json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Переключение статуса задачи
     */
    public function toggleStatus(Request $request, array $params): string
    {
        header('Content-Type: application/json; charset=utf-8');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $taskId = $params['id'] ?? '';
        $status = $request->getBody()['status'] ?? 'completed';
        $userId = $this->auth->userId();

        try {
            $sql = "UPDATE planner_tasks SET status = :status WHERE id = :id AND user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':status' => $status, ':id' => $taskId, ':user_id' => $userId]);

            return json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(500);
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
