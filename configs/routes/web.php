<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);

    $app->group('', function ($app) {
        $app->get('/dashboard', [UserController::class, 'dashboard']);
        $app->post('/logout', [UserController::class, 'logout']);
    })->add(AuthMiddleware::class);

    $app->group('', function ($app) {
        $app->get('/register', [UserController::class, 'registerForm']);
        $app->get('/login', [UserController::class, 'loginForm']);

        $app->post('/register', [UserController::class, 'register']);
        $app->post('/login', [UserController::class, 'login']);
    })->add(GuestMiddleware::class);
};
