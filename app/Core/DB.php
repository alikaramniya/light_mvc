<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    public function __construct(Config $config)
    {
        try {
            $dsn       = [
                $config->get('pdo.driver'),
                ':host=',
                $config->get('pdo.host'),
                ';dbname=',
                $config->get('pdo.dbname'),
                ';charset=',
                $config->get('pdo.charset')
            ];
            $this->pdo = new PDO(
                implode($dsn),
                $config->get('pdo.user'),
                $config->get('pdo.password'),
                $config->get('pdo.options'),
            );
        } catch (\PDOException $e) {
            exit('connection faild: ' . $e->getMessage());
        }
    }

    public function __call(string $method, array $args)
    {
        return call_user_func_array([$this->pdo, $method], $args);
    }
}
