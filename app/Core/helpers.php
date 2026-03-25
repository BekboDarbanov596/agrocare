<?php

/**
 * Global helper functions for the AgroCare application.
 */

if (!function_exists('view')) {
    /**
     * Renders a view within the main layout.
     * 
     * @param string $view The name of the view file (without .php)
     * @param array $data Data to be extracted into the view
     * @return string The rendered HTML content
     */
    function view(string $view, array $data = []): string
    {
        // Extract data to make variables available in views
        extract($data);

        // Set default title if not provided
        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';

        // 1. Render the view content
        ob_start();
        $viewPath = __DIR__ . "/../../views/{$view}.php";
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            return "View [{$view}] not found at {$viewPath}";
        }
        $viewContent = ob_get_clean();

        // 2. Render the layout and inject content
        ob_start();
        $layoutPath = __DIR__ . "/../../views/layouts/main.php";
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            // Fallback if layout is missing
            return $viewContent;
        }
        $layoutContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }
}
