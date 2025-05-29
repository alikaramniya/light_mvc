<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use Slim\App;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);

    $app->get('/user', [UserController::class, 'index']);
    $app->get('/register', [UserController::class, 'registerForm']);
    $app->post('/register', [UserController::class, 'register']);
};