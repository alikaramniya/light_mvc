<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class ValidationErrorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $renderer,
        private readonly SessionInterface $session
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($errros = $this->session->getFlash('errors')) {
            $this->renderer->addAttribute('errors', $errros);
        }

        return $handler->handle($request);
    }
}
