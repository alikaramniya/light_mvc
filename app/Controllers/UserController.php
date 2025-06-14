<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\SessionInterface;
use App\Exceptions\ValidationException;
use App\Models\User;
use App\Requests\LoginUserRequest;
use App\Requests\RegisterUserRequest;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class UserController
{
    public function __construct(
        private readonly PhpRenderer $renderer,
        private readonly User $user,
        private readonly AuthInterface $auth,
        private readonly SessionInterface $session,
        private readonly RequestValidatorFactoryInterface $requestFactory,
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
        $data = $this->requestFactory->make(RegisterUserRequest::class)->validate($request->getParsedBody());

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
        $data = $this->requestFactory->make(LoginUserRequest::class)->validate($request->getParsedBody());

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
