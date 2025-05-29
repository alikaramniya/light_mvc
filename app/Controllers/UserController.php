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
        return $this->renderer->render($response, 'welcome.php');
    }

    public function registerForm(Request $request, Response $response)
    {
        return $this->renderer->render($response, 'auth/register.php');
    }

    public function register(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $res = $this->user->insert($data);

        $response->getBody()->write($res ? 'Success' : 'Failed');

        return $response;
    }
}
