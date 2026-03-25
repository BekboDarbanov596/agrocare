<?php

namespace App\Core;

use App\Core\Router;
use App\Core\Request;
use App\Core\Database;
use App\Core\Config;

class Application
{
    public Router $router;
    public Request $request;
    public Database $db;
    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->db = new Database();

        // Загрузка роутов
        $routes = require __DIR__ . '/../routes.php';
        $routes($this->router);
    }

    public function run(): void
    {
        $this->router->resolve();
    }
}
