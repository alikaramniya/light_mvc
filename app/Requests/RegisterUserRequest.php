<?php

declare(strict_types=1);

namespace App\Requests;

use App\Contracts\RequestValidatorInterface;
use App\Exceptions\ValidationException;
use App\Models\User;
use Valitron\Validator;

class RegisterUserRequest implements RequestValidatorInterface
{
    public function __construct(
        private readonly User $user
    ) {}

    public function validate(array $data): array
    {
        $v = new Validator($data);

        $v
            ->rule('required', array_keys($data))
            ->rule('email', 'email')
            ->rule('equals', 'password', 'confirm-password')
            ->rule(function ($field, $value, $params, $fields) use ($data) {
                return ! $this->user->exists(['email' => $data['email']]);
            }, 'confirm-password')
            ->message('user curently created');

        if (! $v->validate()) {
            throw new ValidationException($v->errors());
        }

        return $data;
    }
}
