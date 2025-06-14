<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserProviderServiceInterface;

class Auth implements AuthInterface
{
    public function __construct(
        private readonly UserProviderServiceInterface $userProvider,
        private readonly SessionInterface $session,
    ) {}

    public function user()
    {
        $userId = $this->session->get('user');
        if (is_null($userId)) {
            return null;
        }

        $user = $this->userProvider->find($userId);
        if (! $user) {
            return null;
        }

        return $user;
    }

    public function attemptLogin(array $data): bool
    {
        $user = $this->userProvider->findBy('email', $data['email']);

        if (! $user || ! $this->getCredentials($user, $data)) {
            return false;
        }

        $this->session->regenerate();

        $this->session->put('user', $user->id);

        return true;
    }

    public function logout(): void
    {
        $this->session->forget('user');

        $this->session->regenerate();
    }

    public function getCredentials($user, $data): bool
    {
        return password_verify($data['password'], $user->password);
    }
}
