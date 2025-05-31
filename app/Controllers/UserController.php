<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Valitron\Validator;

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

        $v = new Validator($data);

        $v
            ->rule('required', array_keys($data))
            ->rule('email', 'email')
            ->rule('equals', 'password', 'confirm-password')
            ->rule(function ($field, $value, $params, $fields) use ($data) {
                return !$this->user->exists(['email' => $data['email']]);
            }, 'confirm-password')
            ->message('user curently created');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        $res = $this->user->insert($data);

        $response->getBody()->write($res ? 'Success' : 'Failed');

        return $response;
    }

    public function loginForm(Request $request, Response $response): Response
    {
        return $this->renderer->render($response, 'auth/login.php');
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $v = new Validator($data);

        $v
            ->rule('required', array_keys($data))
            ->rule('email', 'email');

        if (!$v->validate()) {
            throw new ValidationException($v->errors());
        }

        $user = $this->user->findColumn('email', $data['email']);

        if (!$user || !password_verify($data['password'], $user->password)) {
            throw new ValidationException(['password' => ['Email or Password is incorrect']]);
        }

        session_regenerate_id();

        $_SESSION['user'] = $user->id;

        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
