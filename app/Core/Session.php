<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\SessionInterface;
use App\DataObjects\SessionConfig;
use App\Exceptions\SessionException;

class Session implements SessionInterface
{
    public function __construct(
        private readonly SessionConfig $option
    ) {}

    public function start(): void
    {
        if ($this->isActive()) {
            throw new SessionException('Session has be already created');
        }

        if (headers_sent($filename, $line)) {
            throw new SessionException('Header run already in : '.$filename.' file'.' and '.$line.' line');
        }

        if ($this->option->name) {
            session_name($this->option->name);
        }

        session_set_cookie_params([
            'secure' => $this->option->secure,
            'httponly' => $this->option->httponly,
            'samesite' => $this->option->samesite->value,
        ]);

        session_start();
    }

    public function save(): void
    {
        session_write_close();
    }

    public function isActive(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function regenerate(): void
    {
        session_regenerate_id();
    }

    public function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function flash(string $key, array $message): void
    {
        $_SESSION[$this->option->flash_name][$key] = $message;
    }

    public function getFlash(string $key): array
    {
        $message = $_SESSION[$this->option->flash_name][$key] ?? [];

        unset($_SESSION[$this->option->flash_name][$key]);

        return $message;
    }
}
