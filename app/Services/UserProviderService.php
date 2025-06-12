<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\UserProviderServiceInterface;
use App\Models\User;

class UserProviderService implements UserProviderServiceInterface
{
    public function __construct(
        private readonly User $user
    ) {}

    public function find(int $id)
    {
        return $this->user->find($id);
    }

    public function findBy(string $key, mixed $value)
    {
        return $this->user->findColumn($key, $value);
    }
}
