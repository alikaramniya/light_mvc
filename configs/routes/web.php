<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);

    $app->get('/dashboard', [UserController::class, 'dashboard'])->add(AuthMiddleware::class);

    $app->get('/register', [UserController::class, 'registerForm'])->add(GuestMiddleware::class);
    $app->post('/register', [UserController::class, 'register'])->add(GuestMiddleware::class);
    $app->get('/login', [UserController::class, 'loginForm'])->add(GuestMiddleware::class);
    $app->post('/login', [UserController::class, 'login'])->add(GuestMiddleware::class);

    $app->get('/logout', [UserController::class, 'logout'])->add(AuthMiddleware::class);
};
