<?php

// ВКЛЮЧАЕМ ОШИБКИ ДЛЯ ОТЛАДКИ (TIMEMEB)
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Инициализация сессии
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/app/Core/helpers.php';

use App\Core\Application;

// Загрузка переменных окружения
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Создание и запуск приложения
try {
    $app = new Application();
    $app->run();
} catch (\Throwable $e) {
    // Для API запросов возвращаем JSON ошибку
    if (strpos($_SERVER['REQUEST_URI'] ?? '', '/api/') === 0) {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Внутренняя ошибка сервера: ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    } else {
        // В production — красивая страница ошибки
        http_response_code(500);
        echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Ошибка</title>
        <style>body{background:#0e0c0b;color:#fff;font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;}
        .box{text-align:center;} h1{font-size:48px;font-weight:800;} p{opacity:.5;}</style></head>
        <body><div class="box"><h1>500</h1><p>Что-то пошло не так. Мы уже разбираемся.</p></div></body></html>';
    }
}
