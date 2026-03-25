<?php

namespace App\Controllers;

use App\Core\Request;

class HomeController
{
    public function index(Request $request): string
    {
        $GLOBALS['page_title'] = 'AI Agro Care - Главная';

        // Получаем layout
        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        // Получаем view
        ob_start();
        include __DIR__ . '/../../views/home.php';
        $viewContent = ob_get_clean();

        // Заменяем {{content}} на контент view
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
