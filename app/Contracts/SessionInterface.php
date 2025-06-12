<?php

declare(strict_types=1);

namespace App\Contracts;

interface SessionInterface
{
    public function start(): void;

    public function save(): void;

    public function isActive(): bool;

    public function regenerate(): void;

    public function put(string $key, mixed $value): void;

    public function get(string $key): mixed;

    public function forget(string $key): void;

    public function has(string $key): bool;

    public function flash(string $key, array $message): void;

    public function getFlash(string $key): array;
}
