<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Exceptions\SessionException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Views\PhpRenderer;

class ValidationErrorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly PhpRenderer $renderer
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!empty($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];

            $this->renderer->addAttribute('errors', $errors);

            unset($_SESSION['errors']);
        }

        return $handler->handle($request);
    }
}
