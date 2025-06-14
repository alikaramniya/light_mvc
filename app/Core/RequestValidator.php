<?php

declare(strict_types=1);

namespace App\Core;

use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\RequestValidatorInterface;
use Psr\Container\ContainerInterface;

class RequestValidator implements RequestValidatorFactoryInterface
{
    public function __construct(
        private readonly ContainerInterface $container
    ) {}

    public function make(string $class): RequestValidatorInterface
    {
        $validator = $this->container->get($class);

        if ($validator instanceof RequestValidatorInterface) {
            return $validator;
        }

        throw new \RuntimeException('Faild to instantiate from call "'.$class.'"');
    }
}
