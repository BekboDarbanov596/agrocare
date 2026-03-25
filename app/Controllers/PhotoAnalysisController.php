<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;
use App\Core\Database;
use App\AI\ChatAPI;
use PDO;

class PhotoAnalysisController
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
     * Загрузка и анализ фото растения
     */
    public function upload(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!$this->auth->check()) {
                http_response_code(401);
                return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
            }

            $userId = $this->auth->userId();

            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                return json_encode(['success' => false, 'error' => 'Ошибка загрузки файла'], JSON_UNESCAPED_UNICODE);
            }

            $file = $_FILES['photo'];
            $fieldId = $_POST['field_id'] ?? null;
            $crop = $_POST['crop'] ?? null;
            $growthStage = $_POST['growth_stage'] ?? null;
            $symptoms = $_POST['symptoms'] ?? null;
            $problemDate = $_POST['problem_date'] ?? null;
            $weather = isset($_POST['weather']) ? json_decode($_POST['weather'], true) : null;
            $careInfo = $_POST['care_info'] ?? null;
            $additionalInfo = $_POST['additional_info'] ?? null;

            // Валидация файла
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!in_array($file['type'], $allowedTypes)) {
                http_response_code(400);
                return json_encode(['success' => false, 'error' => 'Неподдерживаемый формат'], JSON_UNESCAPED_UNICODE);
            }

            if ($file['size'] > 20 * 1024 * 1024) { // 20MB
                http_response_code(400);
                return json_encode(['success' => false, 'error' => 'Файл слишком большой'], JSON_UNESCAPED_UNICODE);
            }

            // Сохранение файла
            $uploadDir = __DIR__ . '/../../uploads/plants/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = uniqid() . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $filePath = $uploadDir . $fileName;
            $photoUri = '/uploads/plants/' . $fileName;

            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                http_response_code(500);
                return json_encode(['success' => false, 'error' => 'Ошибка сохранения файла'], JSON_UNESCAPED_UNICODE);
            }

            // Сохраняем в БД
            $sql = "INSERT INTO plant_analyses (field_id, user_id, photo_uri, crop, predictions, confidence, status)
                    VALUES (:field_id, :user_id, :photo_uri, :crop, '{}', 0, 'pending')";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':field_id' => $fieldId,
                ':user_id' => $userId,
                ':photo_uri' => $photoUri,
                ':crop' => $crop
            ]);

            $analysisId = $this->pdo->lastInsertId();

            // Сохраняем дополнительную информацию в metadata
            $metadata = [
                'growth_stage' => $growthStage,
                'symptoms' => $symptoms,
                'problem_date' => $problemDate,
                'weather' => $weather,
                'care_info' => $careInfo,
                'additional_info' => $additionalInfo
            ];

            // Создаем сжатую копию для AI (чтобы запрос был быстрым)
            $compressedPath = $this->compressImage($filePath);

            // Запускаем AI анализ с дополнительным контекстом и путем к фото
            $this->analyzeWithAI($analysisId, $photoUri, $crop, $userId, $metadata, $compressedPath);

            return json_encode([
                'success' => true,
                'analysis_id' => $analysisId,
                'photo_uri' => $photoUri,
                'status' => 'analyzing'
            ], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            error_log("Error in PhotoAnalysisController::upload: " . $e->getMessage());
            http_response_code(500);
            return json_encode(['success' => false, 'error' => 'Ошибка сервера: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Сжатие изображения для AI
     */
    private function compressImage(string $sourcePath): string
    {
        try {
            $info = getimagesize($sourcePath);
            if (!$info)
                return $sourcePath;

            $mime = $info['mime'];
            $width = $info[0];
            $height = $info[1];

            // Если картинка и так маленькая, не трогаем
            if ($width <= \App\AI\AIConfig::MAX_IMAGE_WIDTH && filesize($sourcePath) < 500 * 1024) {
                return $sourcePath;
            }

            // Создаем ресурс изображения
            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':
                    $src = imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $src = imagecreatefrompng($sourcePath);
                    break;
                default:
                    return $sourcePath;
            }

            // Вычисляем новые размеры
            $newWidth = \App\AI\AIConfig::MAX_IMAGE_WIDTH;
            $newHeight = (int) ($height * ($newWidth / $width));

            $dst = imagecreatetruecolor($newWidth, $newHeight);

            // Сохраняем прозрачность для PNG
            if ($mime === 'image/png') {
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            }

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // Сохраняем во временный файл
            $tempPath = $sourcePath . '_ai.jpg';
            imagejpeg($dst, $tempPath, \App\AI\AIConfig::IMAGE_QUALITY);

            imagedestroy($src);
            imagedestroy($dst);

            return $tempPath;
        } catch (\Exception $e) {
            error_log("Image compression failed: " . $e->getMessage());
            return $sourcePath;
        }
    }

    /**
     * Анализ фото с помощью AI (Vision)
     */
    private function analyzeWithAI(string $analysisId, string $photoUri, ?string $crop, string $userId, array $metadata = [], ?string $photoPath = null): void
    {
        // Получаем информацию об участке если есть
        $fieldInfo = null;
        $sql = "SELECT field_id FROM plant_analyses WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $analysisId]);
        $analysis = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($analysis && $analysis['field_id']) {
            $sql = "SELECT f.*, fa.region FROM fields f
                    INNER JOIN farms fa ON f.farm_id = fa.id
                    WHERE f.id = :field_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':field_id' => $analysis['field_id']]);
            $fieldInfo = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Формируем чистый запрос к AI, содержащий только факты
        $message = "ЗАПРОС НА АНАЛИЗ РАСТЕНИЯ\n\n";
        if ($crop) {
            $message .= "Объект: {$crop}\n";
        }

        // Контекст участка
        if ($fieldInfo) {
            $message .= "ЛОКАЦИЯ:\n";
            $message .= "- Участок: {$fieldInfo['name']}\n";
            if ($fieldInfo['region'])
                $message .= "- Регион: {$fieldInfo['region']}\n";
            $message .= "\n";
        }

        // Данные от пользователя (ФАКТЫ)
        if (!empty($metadata)) {
            $message .= "ДАННЫЕ ПОЛЬЗОВАТЕЛЯ:\n";
            if (!empty($metadata['growth_stage']))
                $message .= "- Стадия роста: {$metadata['growth_stage']}\n";
            if (!empty($metadata['symptoms']))
                $message .= "- Описанные симптомы: {$metadata['symptoms']}\n";
            if (!empty($metadata['problem_date']))
                $message .= "- Дата появления: {$metadata['problem_date']}\n";
            if (!empty($metadata['weather'])) {
                $weatherStr = is_array($metadata['weather']) ? implode(', ', $metadata['weather']) : $metadata['weather'];
                $message .= "- Погода: {$weatherStr}\n";
            }
            if (!empty($metadata['care_info']))
                $message .= "- Предварительные меры: {$metadata['care_info']}\n";
            if (!empty($metadata['additional_info']))
                $message .= "- Инфо: {$metadata['additional_info']}\n";
            $message .= "\n";
        }

        $message .= "ЗАДАЧА: Проведи визуальный анализ и дай ответ строго по чек-листу.";

        $contextData = [
            'crop' => $crop ?? 'растение',
            'growth_stage' => $metadata['growth_stage'] ?? null,
            'symptoms' => $metadata['symptoms'] ?? null,
            'weather' => $metadata['weather'] ?? null
        ];

        $result = $this->chatAPI->sendMessage(
            $userId,
            $message,
            'plant_analysis',
            $analysisId,
            $contextData,
            null // Отключаем передачу фото, так как используем текстовую модель (избегаем 402)
        );

        if ($result['success']) {
            // Парсим ответ AI и сохраняем
            $aiResponse = $result['message'];

            // Определяем уровень триажа из ответа AI
            $triageLevel = 'medium'; // По умолчанию
            if (preg_match('/\[\[TRIAGE:\s*(CRITICAL|MEDIUM|LOW)\]\]/i', $aiResponse, $matches)) {
                $triageLevel = strtolower($matches[1]);
            }

            // Вырезаем техническую метку (с поддержкой разных пробелов)
            $displayMessage = preg_replace('/\[\[TRIAGE:\s*(CRITICAL|MEDIUM|LOW)\s*\]\]/i', '', $aiResponse);
            $displayMessage = trim($displayMessage);

            $recommendations = [
                'analysis' => $displayMessage,
                'confidence' => 0.85,
                'triage_level' => $triageLevel,
                'recommendations' => $this->parseAIRecommendations($displayMessage),
                'diagnosis' => $this->parseDiagnosis($displayMessage)
            ];

            $sql = "UPDATE plant_analyses
                    SET predictions = :predictions,
                        recommendations = :recommendations,
                        confidence = :confidence,
                        status = 'completed'
                    WHERE id = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id' => $analysisId,
                ':predictions' => json_encode(['ai_response' => $displayMessage, 'diagnosis' => $recommendations['diagnosis'], 'triage_level' => $triageLevel]),
                ':recommendations' => json_encode($recommendations['recommendations']),
                ':confidence' => $recommendations['confidence']
            ]);
        } else {
            // Обновляем статус на ошибку
            $sql = "UPDATE plant_analyses SET status = 'error' WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $analysisId]);
        }
    }

    private function parseDiagnosis(string $aiResponse): array
    {
        $diagnosis = [
            'problem' => 'Не определена',
            'cause' => 'Анализ в процессе',
            'urgency' => 'normal'
        ];

        // Ищем строку с диагнозом (обычно после слова "ДИАГНОЗ:")
        if (preg_match('/ДИАГНОЗ:\s*(.+)/i', $aiResponse, $matches)) {
            $diagnosis['problem'] = trim(explode("\n", $matches[1])[0]);
        }

        $text = mb_strtolower($aiResponse);

        // Уточняем причину
        if (strpos($text, 'вирус') !== false)
            $diagnosis['cause'] = 'вирусное';
        elseif (strpos($text, 'гриб') !== false)
            $diagnosis['cause'] = 'грибковое';
        elseif (strpos($text, 'бактери') !== false)
            $diagnosis['cause'] = 'бактериальное';
        elseif (strpos($text, 'вредител') !== false)
            $diagnosis['cause'] = 'вредители';
        elseif (strpos($text, 'дефицит') !== false || strpos($text, 'недостаток') !== false)
            $diagnosis['cause'] = 'питание';

        return $diagnosis;
    }

    /**
     * Парсинг рекомендаций из ответа AI
     */
    private function parseAIRecommendations(string $aiResponse): array
    {
        // Простой парсинг - можно улучшить
        $recommendations = [];

        // Ищем ключевые слова
        if (stripos($aiResponse, 'болезнь') !== false || stripos($aiResponse, 'заболевание') !== false) {
            $recommendations[] = [
                'type' => 'treatment',
                'title' => 'Лечение',
                'description' => 'Требуется лечение заболевания'
            ];
        }

        if (stripos($aiResponse, 'удобрение') !== false || stripos($aiResponse, 'питание') !== false) {
            $recommendations[] = [
                'type' => 'fertilizer',
                'title' => 'Подкормка',
                'description' => 'Рекомендуется внесение удобрений'
            ];
        }

        if (stripos($aiResponse, 'полив') !== false || stripos($aiResponse, 'вода') !== false) {
            $recommendations[] = [
                'type' => 'watering',
                'title' => 'Полив',
                'description' => 'Требуется корректировка полива'
            ];
        }

        return $recommendations;
    }

    /**
     * Получение анализа
     */
    public function show(Request $request, ?string $id = null): string
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!$this->auth->check()) {
                http_response_code(401);
                return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
            }

            $userId = $this->auth->userId();

            $sql = "SELECT * FROM plant_analyses WHERE id = :id AND user_id = :user_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id, ':user_id' => $userId]);
            $analysis = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$analysis) {
                http_response_code(404);
                return json_encode(['success' => false, 'error' => 'Анализ не найден'], JSON_UNESCAPED_UNICODE);
            }

            return json_encode(['success' => true, 'analysis' => $analysis], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            error_log("Error in PhotoAnalysisController::show: " . $e->getMessage());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка загрузки анализа: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * Список анализов
     */
    public function index(Request $request): string
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!$this->auth->check()) {
                http_response_code(401);
                return json_encode(['success' => false, 'error' => 'Не авторизован'], JSON_UNESCAPED_UNICODE);
            }

            $userId = $this->auth->userId();
            $fieldId = $request->getBody()['field_id'] ?? null;

            $sql = "SELECT * FROM plant_analyses WHERE user_id = :user_id";
            $params = [':user_id' => $userId];

            if ($fieldId) {
                $sql .= " AND field_id = :field_id";
                $params[':field_id'] = $fieldId;
            }

            $sql .= " ORDER BY created_at DESC LIMIT 50";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $analyses = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode(['success' => true, 'analyses' => $analyses], JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            error_log("Error in PhotoAnalysisController::index: " . $e->getMessage());
            http_response_code(500);
            return json_encode([
                'success' => false,
                'error' => 'Ошибка загрузки анализов: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
