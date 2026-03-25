<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;

class DashboardController
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function index(Request $request): string
    {
        // Проверяем авторизацию
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        // Проверяем роль пользователя
        $user = $this->auth->user();
        if ($user && $user['role'] === 'veterinarian') {
            // Редирект ветеринаров на их dashboard
            header('Location: /dashboard-vet');
            exit;
        }

        $GLOBALS['page_title'] = 'Личный кабинет - AI Agro Care';

        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/dashboard.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function vetDashboard(Request $request): string
    {
        // Проверяем авторизацию
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        // Проверяем роль
        $user = $this->auth->user();
        if (!$user || $user['role'] !== 'veterinarian') {
            header('Location: /dashboard');
            exit;
        }

        $GLOBALS['page_title'] = 'Dashboard ветеринара - AI Agro Care';

        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/dashboard-vet.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
