<?php

use App\Controllers\HomeController;
use App\Controllers\DashboardController;
use App\Controllers\AuthController;
use App\Controllers\AIController;
use App\Controllers\FarmController;
use App\Controllers\FieldController;
use App\Controllers\PhotoAnalysisController;
use App\Controllers\PlanController;
use App\Controllers\PhotoAnalysisPageController;
use App\Controllers\AnimalsPageController;
use App\Controllers\AuthPageController;
use App\Controllers\FieldPlanController;
use App\Controllers\AnimalCaseController;
use App\Controllers\CropCycleController;
use App\Controllers\VetProfileController;
use App\Controllers\UserChatController;
use App\Controllers\ServicesPageController;
use App\Controllers\PlannerController;
use App\Controllers\ReportPageController;

return function ($router) {
    // Главная страница (лендинг)
    $router->get('/', [HomeController::class, 'index']);

    // Dashboard (личный кабинет для авторизованных)
    $router->get('/dashboard', [DashboardController::class, 'index']);

    // Страницы аутентификации
    $router->get('/login', [AuthPageController::class, 'login']);
    $router->get('/register', [AuthPageController::class, 'register']);

    // Страницы приложения
    $router->get('/plan', [PlanController::class, 'index']);
    $router->get('/photo-analysis', [PhotoAnalysisPageController::class, 'index']);
    $router->get('/animals', [AnimalsPageController::class, 'index']);
    $router->get('/chat', [\App\Controllers\ChatController::class, 'index']);
    $router->get('/services', [ServicesPageController::class, 'index']);
    $router->get('/planner', [PlannerController::class, 'view']);
    $router->get('/reports', [ReportPageController::class, 'index']);

    // Страницы для ветеринаров
    $router->get('/dashboard-vet', [DashboardController::class, 'vetDashboard']);
    $router->get('/vet-profile', [\App\Controllers\VetProfilePageController::class, 'index']);
    $router->get('/veterinarians', [\App\Controllers\VeterinariansPageController::class, 'index']);

    // Чат между пользователями
    $router->get('/chat-user/:userId', [\App\Controllers\UserChatPageController::class, 'index']);

    // ===== АУТЕНТИФИКАЦИЯ =====
    $router->post('/api/auth/register', [AuthController::class, 'register']);
    $router->post('/api/auth/login', [AuthController::class, 'login']);
    $router->post('/api/auth/logout', [AuthController::class, 'logout']);
    $router->get('/api/auth/me', [AuthController::class, 'me']);

    // ===== AI ЧАТ =====
    $router->post('/api/ai/chat', [AIController::class, 'chat']);
    $router->get('/api/ai/history', [AIController::class, 'history']);
    $router->get('/api/ai/sessions', [AIController::class, 'sessions']);
    $router->post('/api/ai/delete-session', [AIController::class, 'deleteSession']);

    // ===== ХОЗЯЙСТВА =====
    $router->get('/api/farms', [FarmController::class, 'index']);
    $router->post('/api/farms', [FarmController::class, 'create']);
    $router->get('/api/farms/:id', [FarmController::class, 'show']);
    $router->put('/api/farms/:id', [FarmController::class, 'update']);
    $router->delete('/api/farms/:id', [FarmController::class, 'delete']);

    // ===== УЧАСТКИ =====
    $router->get('/api/fields', [FieldController::class, 'index']);
    $router->post('/api/fields', [FieldController::class, 'create']);
    $router->get('/api/fields/:id', [FieldController::class, 'show']);
    $router->put('/api/fields/:id', [FieldController::class, 'update']);
    $router->delete('/api/fields/:id', [FieldController::class, 'delete']);

    // ===== АНАЛИЗ ФОТО =====
    $router->post('/api/photo-analysis/upload', [PhotoAnalysisController::class, 'upload']);
    $router->get('/api/photo-analysis', [PhotoAnalysisController::class, 'index']);
    $router->get('/api/photo-analysis/:id', [PhotoAnalysisController::class, 'show']);

    // ===== ПЛАНЫ УЧАСТКОВ =====
    $router->post('/api/field-plans', [FieldPlanController::class, 'create']);
    $router->get('/api/field-plans', [FieldPlanController::class, 'index']);

    // ===== КЕЙСЫ ЖИВОТНЫХ =====
    $router->post('/api/animal-cases', [AnimalCaseController::class, 'create']);
    $router->get('/api/animal-cases', [AnimalCaseController::class, 'index']);

    // ===== ИСТОРИЯ ПОСЕВОВ =====
    $router->get('/api/crop-cycles', [CropCycleController::class, 'index']);
    $router->post('/api/crop-cycles', [CropCycleController::class, 'create']);

    // ===== ПРОФИЛИ ВЕТЕРИНАРОВ =====
    $router->get('/api/vet-profile', [VetProfileController::class, 'getOrCreate']);
    $router->put('/api/vet-profile', [VetProfileController::class, 'update']);
    $router->get('/api/veterinarians', [VetProfileController::class, 'list']);

    // ===== ЧАТ МЕЖДУ ПОЛЬЗОВАТЕЛЯМИ =====
    $router->get('/api/user-chats', [UserChatController::class, 'getChats']);
    $router->get('/api/user-chats/:chatId/messages', [UserChatController::class, 'getMessages']);
    $router->post('/api/user-chats/message', [UserChatController::class, 'sendMessage']);
    $router->get('/api/user-chats/with/:userId', [UserChatController::class, 'getOrCreateChat']);

    // ===== ПЛАНИРОВЩИК (PLANNER) =====
    $router->get('/api/planner/tasks', [PlannerController::class, 'index']);
    $router->post('/api/planner/tasks', [PlannerController::class, 'create']);
    $router->delete('/api/planner/tasks/:id', [PlannerController::class, 'delete']);
    $router->put('/api/planner/tasks/:id/status', [PlannerController::class, 'toggleStatus']);
};
