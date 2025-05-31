<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index'])->add(AuthMiddleware::class);

    $app->get('/user', [UserController::class, 'index']);
    $app->get('/register', [UserController::class, 'registerForm']);
    $app->post('/register', [UserController::class, 'register']);
    $app->get('/login', [UserController::class, 'loginForm']);
    $app->post('/login', [UserController::class, 'login']);
};
