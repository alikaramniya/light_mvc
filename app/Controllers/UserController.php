<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Exceptions\ValidationException;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Valitron\Validator;

class UserController
{
    public function __construct(
        private readonly PhpRenderer $renderer,
        private readonly User $user,
        private readonly AuthInterface $auth,
        private readonly SessionInterface $session
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
                return ! $this->user->exists(['email' => $data['email']]);
            }, 'confirm-password')
            ->message('user curently created');

        if (! $v->validate()) {
            throw new ValidationException($v->errors());
        }

        $lastId = $this->user->insert($data);

        $this->session->put('user', (int) $lastId);

        return $response->withHeader('Location', '/dashboard')->withStatus(302);
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

        if (! $v->validate()) {
            throw new ValidationException($v->errors());
        }

        if (! $this->auth->attemptLogin($data)) {
            throw new ValidationException(['password' => ['Email or Password is incorrect']]);
        }

        return $response->withHeader('Location', '/dashboard')->withStatus(302);
    }

    public function dashboard(Request $request, Response $response): Response
    {
        return $this->renderer->render($response, 'dashboard.php');
    }

    public function logout(Request $request, Response $response): Response
    {
        $this->auth->logout();

        return $response->withHeader('Location', '/login')->withStatus(302);
    }
}
