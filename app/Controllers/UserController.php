<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class UserController
{
    public function __construct(
        private PhpRenderer $renderer,
        private User $user
    ) {}

    public function index(Request $request, Response $response, $args)
    {
        return $this->renderer->render($response, 'welcome.php', [
            'user' => $this->user->find(1)
        ]);
    }
}
