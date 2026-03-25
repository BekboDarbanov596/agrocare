<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Auth;

class AuthController
{
    private Auth $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    public function register(Request $request): string
    {
        header('Content-Type: application/json');

        $body = $request->getBody();
        $email = $body['email'] ?? '';
        $phone = $body['phone'] ?? '';
        $password = $body['password'] ?? '';
        $role = $body['role'] ?? 'farmer';
        $vetPhone = $body['vet_phone'] ?? null;

        $result = $this->auth->register($email, $phone, $password, $role, $vetPhone);

        http_response_code($result['success'] ? 201 : 400);
        return json_encode($result);
    }

    public function login(Request $request): string
    {
        header('Content-Type: application/json');

        $body = $request->getBody();
        $emailOrPhone = $body['email'] ?? $body['phone'] ?? '';
        $password = $body['password'] ?? '';

        $result = $this->auth->login($emailOrPhone, $password);

        http_response_code($result['success'] ? 200 : 401);
        return json_encode($result);
    }

    public function logout(Request $request): string
    {
        header('Content-Type: application/json');

        $this->auth->logout();

        return json_encode(['success' => true, 'message' => 'Выход выполнен']);
    }

    public function me(Request $request): string
    {
        header('Content-Type: application/json');

        $user = $this->auth->user();

        if (!$user) {
            http_response_code(401);
            return json_encode(['success' => false, 'error' => 'Не авторизован']);
        }

        return json_encode(['success' => true, 'user' => $user]);
    }
}
