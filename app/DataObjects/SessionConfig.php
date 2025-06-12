<?php

declare(strict_types=1);

namespace App\DataObjects;

use App\Enums\SameSite;

class SessionConfig
{
    public function __construct(
        public readonly string $name,
        public readonly string $flash_name,
        public readonly bool $secure,
        public readonly bool $httponly,
        public readonly SameSite $samesite
    ) {}
}
