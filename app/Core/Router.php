<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get(string $path, $callback): void
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, $callback): void
    {
        $this->routes['post'][$path] = $callback;
    }

    public function put(string $path, $callback): void
    {
        $this->routes['put'][$path] = $callback;
    }

    public function delete(string $path, $callback): void
    {
        $this->routes['delete'][$path] = $callback;
    }

    public function resolve(): void
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        // Убираем trailing slash
        $path = rtrim($path, '/') ?: '/';

        // Сначала проверяем точное совпадение
        $callback = $this->routes[$method][$path] ?? false;
        $params = [];

        // Если не найдено, ищем с параметрами
        if ($callback === false) {
            foreach ($this->routes[$method] ?? [] as $route => $routeCallback) {
                $pattern = $this->convertRouteToPattern($route);
                if (preg_match($pattern, $path, $matches)) {
                    $callback = $routeCallback;
                    // Извлекаем параметры
                    preg_match_all('/:(\w+)/', $route, $paramNames);
                    foreach ($paramNames[1] as $index => $paramName) {
                        $params[$paramName] = $matches[$index + 1] ?? null;
                    }
                    break;
                }
            }
        }

        if ($callback === false) {
            http_response_code(404);
            if ($this->request->isJson() || strpos($path, '/api/') === 0) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Not Found']);
            } else {
                echo '<h1>404 - Страница не найдена</h1>';
            }
            return;
        }

        if (is_string($callback)) {
            $this->renderView($callback);
            return;
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        // Передаем параметры в callback
        $args = [$this->request];
        foreach ($params as $paramValue) {
            $args[] = $paramValue;
        }

        try {
            $result = call_user_func_array($callback, $args);

            if (is_string($result)) {
                // Если это API запрос и результат строка, проверяем, не JSON ли это
                if (strpos($path, '/api/') === 0) {
                    // Если строка уже JSON, просто выводим
                    if (json_decode($result) !== null) {
                        header('Content-Type: application/json; charset=utf-8');
                        echo $result;
                    } else {
                        // Иначе оборачиваем в JSON
                        header('Content-Type: application/json; charset=utf-8');
                        echo json_encode(['success' => true, 'data' => $result], JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    echo $result;
                }
            } elseif (is_array($result) || is_object($result)) {
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($result, JSON_UNESCAPED_UNICODE);
            }
        } catch (\Throwable $e) {
            // Для API запросов возвращаем JSON ошибку
            if (strpos($path, '/api/') === 0) {
                header('Content-Type: application/json; charset=utf-8');
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'error' => 'Ошибка выполнения: ' . $e->getMessage()
                ], JSON_UNESCAPED_UNICODE);
            } else {
                throw $e;
            }
        }
    }

    /**
     * Конвертация роута с параметрами в regex паттерн
     */
    private function convertRouteToPattern(string $route): string
    {
        $pattern = preg_replace('/:(\w+)/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }

    private function renderView(string $view): void
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        echo str_replace('{{content}}', $viewContent, $layoutContent);
    }

    private function layoutContent(): string
    {
        $title = $GLOBALS['page_title'] ?? 'AI Agro Care';
        ob_start();
        include __DIR__ . "/../../views/layouts/main.php";
        return ob_get_clean();
    }

    private function renderOnlyView(string $view): string
    {
        ob_start();
        include_once __DIR__ . "/../../views/{$view}.php";
        return ob_get_clean();
    }
}
