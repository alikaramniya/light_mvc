<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Exceptions\SessionException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class StartSessionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly ResponseFactoryInterface $response
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException('Session has be already created');
        }

        if (headers_sent($filename, $line)) {
            throw new SessionException('Header run already');
        }

        session_set_cookie_params(['secure' => true, 'httponly' => true, 'samesite' => 'lax']);

        session_start();

        $response = $handler->handle($request);

        session_write_close();

        return $response;
    }
}
