<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;

class VetProfilePageController
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function index(Request $request): string
    {
        if (!$this->auth->check()) {
            header('Location: /login');
            exit;
        }

        $user = $this->auth->user();
        if (!$user || $user['role'] !== 'veterinarian') {
            header('Location: /dashboard');
            exit;
        }

        $GLOBALS['page_title'] = 'Профиль ветеринара - AI Agro Care';

        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/vet-profile.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
