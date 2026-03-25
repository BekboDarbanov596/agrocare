<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;

class ChatController
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    /**
     * Страница чата с AI по плану
     */
    public function index(Request $request): string
    {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $planId = $_GET['plan_id'] ?? null;
        $analysisId = $_GET['analysis_id'] ?? null;

        if ($planId) {
            $GLOBALS['page_title'] = 'Обсуждение плана с AI - AI Agro Care';
        } elseif ($analysisId) {
            $GLOBALS['page_title'] = 'Обсуждение анализа фото с AI - AI Agro Care';
        } else {
            $GLOBALS['page_title'] = 'Чат с AI - AI Agro Care';
        }

        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/chat.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
