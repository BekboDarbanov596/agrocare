<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\AI\ChatAPI;

class AIController
{
    private ChatAPI $chatAPI;
    private Auth $auth;

    public function __construct()
    {
        $this->chatAPI = new ChatAPI();
        $this->auth = new Auth();
    }

    /**
     * Отправка сообщения в AI
     */
    public function chat(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $message = $body['message'] ?? '';
        $contextType = $body['context_type'] ?? 'general';
        $contextId = !empty($body['context_id']) ? $body['context_id'] : null;
        $contextData = $body['context_data'] ?? [];

        if (empty($message)) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => 'Сообщение не может быть пустым']);
        }

        $userId = $this->auth->userId();

        // Если context_id это UUID плана, добавляем контекст плана
        if ($contextId && $contextType === 'plan_advice') {
            $planInfo = $this->getPlanInfo($contextId, $userId);
            if ($planInfo) {
                $contextData = array_merge($contextData, [
                    'plan_id' => $contextId,
                    'crop' => $planInfo['crop'] ?? '',
                    'region' => $planInfo['region'] ?? '',
                    'area' => $planInfo['area_hectares'] ?? null
                ]);
            }
        }

        // Если context_id это UUID анализа фото, добавляем контекст анализа
        if ($contextId && $contextType === 'plant_analysis') {
            $analysisInfo = $this->getAnalysisInfo($contextId, $userId);
            if ($analysisInfo) {
                $contextData = array_merge($contextData, [
                    'analysis_id' => $contextId,
                    'crop' => $analysisInfo['crop'] ?? '',
                    'photo_uri' => $analysisInfo['photo_uri'] ?? null
                ]);
            }
        }

        // Если context_id это UUID кейса животного, добавляем контекст кейса
        if ($contextId && $contextType === 'animal_help') {
            $caseInfo = $this->getCaseInfo($contextId, $userId);
            if ($caseInfo) {
                $contextData = array_merge($contextData, [
                    'case_id' => $contextId,
                    'species' => $caseInfo['species'] ?? '',
                    'symptoms' => $caseInfo['symptoms'] ?? null
                ]);
            }
        }

        // Добавляем флаг, что это чат (чтобы ИИ не повторял формат отчета)
        $contextData['is_chat'] = true;

        $result = $this->chatAPI->sendMessage($userId, $message, $contextType, $contextId, $contextData);

        http_response_code($result['success'] ? 200 : 500);
        return json_encode($result);
    }

    /**
     * Получение истории чата
     */
    public function history(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        // Получаем параметры из GET или POST
        $contextType = $_GET['context_type'] ?? $request->getBody()['context_type'] ?? 'general';
        $contextId = $_GET['context_id'] ?? $request->getBody()['context_id'] ?? null;
        $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : (isset($request->getBody()['limit']) ? (int) $request->getBody()['limit'] : 50);

        $userId = $this->auth->userId();

        // Логируем для отладки
        error_log("AI History request: user_id=$userId, context_type=$contextType, context_id=" . ($contextId ?? 'NULL'));

        $history = $this->chatAPI->getChatHistory($userId, $contextType, $contextId, $limit);

        // Если история пустая и это план, пытаемся загрузить AI анализ из плана
        if (empty($history) && $contextType === 'plan_advice' && $contextId) {
            $planAnalysis = $this->getPlanAnalysis($contextId, $userId);
            if ($planAnalysis) {
                // Добавляем AI анализ как первое сообщение от assistant
                $history[] = [
                    'id' => null,
                    'role' => 'assistant',
                    'content' => $planAnalysis,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                error_log("Added plan analysis to chat history");
            }
        }

        // Если история пустая и это анализ фото, пытаемся загрузить AI анализ из анализа фото
        if (empty($history) && $contextType === 'plant_analysis' && $contextId) {
            $photoAnalysis = $this->getPhotoAnalysis($contextId, $userId);
            if ($photoAnalysis) {
                // Добавляем AI анализ как первое сообщение от assistant
                $history[] = [
                    'id' => null,
                    'role' => 'assistant',
                    'content' => $photoAnalysis,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                error_log("Added photo analysis to chat history");
            }
        }

        // Если история пустая и это кейс животного, пытаемся загрузить AI анализ из кейса
        if (empty($history) && $contextType === 'animal_help' && $contextId) {
            $caseAnalysis = $this->getCaseAnalysis($contextId, $userId);
            if ($caseAnalysis) {
                // Добавляем AI анализ как первое сообщение от assistant
                $history[] = [
                    'id' => null,
                    'role' => 'assistant',
                    'content' => $caseAnalysis,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                error_log("Added case analysis to chat history");
            }
        }

        error_log("AI History result: " . count($history) . " messages found");

        return json_encode(['success' => true, 'messages' => $history]);
    }

    /**
     * Получение списка сессий чата
     */
    public function sessions(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $userId = $this->auth->userId();
        $sessions = $this->chatAPI->getChatSessions($userId);

        return json_encode(['success' => true, 'sessions' => $sessions]);
    }

    /**
     * Удаление сессии чата
     */
    public function deleteSession(Request $request): string
    {
        header('Content-Type: application/json');

        if (!$this->auth->check()) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        $body = $request->getBody();
        $contextType = $body['context_type'] ?? 'general';
        $contextId = $body['context_id'] ?? null;
        $userId = $this->auth->userId();

        $success = $this->chatAPI->deleteSession($userId, $contextType, $contextId);

        return json_encode(['success' => $success]);
    }

    /**
     * Получение информации о плане для контекста
     */
    private function getPlanInfo(string $planId, string $userId): ?array
    {
        try {
            $db = new \App\Core\Database();
            $pdo = $db->getConnection();

            $sql = "SELECT fp.*, f.name as field_name
                    FROM field_plans fp
                    INNER JOIN fields f ON fp.field_id = f.id
                    INNER JOIN farms fa ON f.farm_id = fa.id
                    INNER JOIN user_farms uf ON fa.id = uf.farm_id
                    WHERE fp.id = :plan_id AND uf.user_id = :user_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':plan_id' => $planId, ':user_id' => $userId]);
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Получение AI анализа из плана (для старых планов без истории чата)
     */
    private function getPlanAnalysis(string $planId, string $userId): ?string
    {
        try {
            $db = new \App\Core\Database();
            $pdo = $db->getConnection();

            // Fetch plan data - in MySQL JSON columns are returned as strings by default
            $sql = "SELECT fp.plan_data as plan_data_json
                    FROM field_plans fp
                    INNER JOIN fields f ON fp.field_id = f.id
                    INNER JOIN farms fa ON f.farm_id = fa.id
                    INNER JOIN user_farms uf ON fa.id = uf.farm_id
                    WHERE fp.id = :plan_id AND uf.user_id = :user_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':plan_id' => $planId, ':user_id' => $userId]);
            $plan = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($plan && !empty($plan['plan_data_json'])) {
                // Декодируем JSON строку
                $planData = json_decode($plan['plan_data_json'], true);

                if ($planData && isset($planData['ai_analysis'])) {
                    $analysis = $planData['ai_analysis'];
                    // Убеждаемся, что получаем полный текст
                    $analysisLength = strlen($analysis);
                    error_log("Plan analysis loaded: length=$analysisLength");
                    if ($analysisLength > 0) {
                        error_log("First 200 chars: " . substr($analysis, 0, 200));
                        error_log("Last 200 chars: " . substr($analysis, -200));
                    }
                    return $analysis;
                } else {
                    error_log("Plan data found but ai_analysis missing. Keys: " . implode(', ', array_keys($planData ?? [])));
                }
            } else {
                error_log("No plan data found for plan_id=$planId");
            }

            return null;
        } catch (\Exception $e) {
            error_log("Error getting plan analysis: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Получение информации об анализе фото для контекста
     */
    private function getAnalysisInfo(string $analysisId, string $userId): ?array
    {
        try {
            $db = new \App\Core\Database();
            $pdo = $db->getConnection();

            $sql = "SELECT pa.*, f.name as field_name, fa.region
                    FROM plant_analyses pa
                    LEFT JOIN fields f ON pa.field_id = f.id
                    LEFT JOIN farms fa ON f.farm_id = fa.id
                    WHERE pa.id = :analysis_id AND pa.user_id = :user_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':analysis_id' => $analysisId, ':user_id' => $userId]);
            $analysis = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $analysis ?: null;
        } catch (\Exception $e) {
            error_log("Error getting analysis info: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Получение AI анализа фото для отображения в чате
     */
    private function getPhotoAnalysis(string $analysisId, string $userId): ?string
    {
        try {
            $db = new \App\Core\Database();
            $pdo = $db->getConnection();

            $sql = "SELECT predictions as predictions_json
                    FROM plant_analyses
                    WHERE id = :analysis_id AND user_id = :user_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':analysis_id' => $analysisId, ':user_id' => $userId]);
            $analysis = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($analysis && !empty($analysis['predictions_json'])) {
                $predictions = json_decode($analysis['predictions_json'], true);
                if ($predictions && isset($predictions['ai_response'])) {
                    $aiResponse = $predictions['ai_response'];
                    $analysisLength = strlen($aiResponse);
                    error_log("Photo analysis loaded: length=$analysisLength");
                    return $aiResponse;
                }
            }

            return null;
        } catch (\Exception $e) {
            error_log("Error getting photo analysis: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Получение информации о кейсе животного для контекста
     */
    private function getCaseInfo(string $caseId, string $userId): ?array
    {
        try {
            $db = new \App\Core\Database();
            $pdo = $db->getConnection();

            $sql = "SELECT ac.*, f.name as farm_name
                    FROM animal_cases ac
                    LEFT JOIN farms f ON ac.farm_id = f.id
                    WHERE ac.id = :case_id AND ac.user_id = :user_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':case_id' => $caseId, ':user_id' => $userId]);
            $case = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($case) {
                $symptoms = json_decode($case['symptoms'] ?? '{}', true);
                $case['symptoms'] = $symptoms['text'] ?? '';
            }

            return $case ?: null;
        } catch (\Exception $e) {
            error_log("Error getting case info: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Получение AI анализа кейса животного для отображения в чате
     */
    private function getCaseAnalysis(string $caseId, string $userId): ?string
    {
        try {
            $db = new \App\Core\Database();
            $pdo = $db->getConnection();

            $sql = "SELECT recommendations as recommendations_json
                    FROM animal_cases
                    WHERE id = :case_id AND user_id = :user_id";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([':case_id' => $caseId, ':user_id' => $userId]);
            $case = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($case && !empty($case['recommendations_json'])) {
                $recommendations = json_decode($case['recommendations_json'], true);
                if ($recommendations && isset($recommendations['ai_analysis'])) {
                    $aiAnalysis = $recommendations['ai_analysis'];
                    $analysisLength = strlen($aiAnalysis);
                    error_log("Case analysis loaded: length=$analysisLength");
                    return $aiAnalysis;
                }
            }

            return null;
        } catch (\Exception $e) {
            error_log("Error getting case analysis: " . $e->getMessage());
            return null;
        }
    }
}
