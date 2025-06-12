<?php

declare(strict_types=1);

namespace App\Contracts;

interface UserProviderServiceInterface
{
    public function find(int $id);

    public function findBy(string $key, mixed $value);
}
