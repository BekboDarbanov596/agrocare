<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;

class UserChatPageController
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function index(Request $request, string $userId): string
    {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $currentUserId = $this->auth->userId();
        if ($currentUserId === $userId) {
            header('Location: /dashboard');
            exit;
        }

        $GLOBALS['page_title'] = 'Чат - AI Agro Care';
        $GLOBALS['chat_user_id'] = $userId;
        $GLOBALS['current_user_id'] = $currentUserId;

        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/user-chat.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
