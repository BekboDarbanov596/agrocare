<?php

namespace App\Controllers;

use App\Core\Request;

class PlanController
{
    public function index(Request $request): string
    {
        $GLOBALS['page_title'] = 'План участка - AI Agro Care';

        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . '/../../views/layouts/main.php';
        $layoutContent = ob_get_clean();

        ob_start();
        include __DIR__ . '/../../views/plan.php';
        $viewContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
