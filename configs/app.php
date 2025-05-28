<?php

function getBoolValue(string $value)
{
    if ($value === 'true' || $value === 'TRUE') {
        return true;
    }

    if ($value === 'false' || $value === 'FALSE') {
        return false;
    }
}

return [
    'display_error'          => getBoolValue($_ENV['APP_DEBUG']),
    'error_reporting'        => true,
    'error_reporting_detail' => true,
    'pdo'                    => [
        'dbname'   => $_ENV['DB_DATABASE'],
        'host'     => $_ENV['DB_HOST'],
        'user'     => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
        'driver'   => $_ENV['DB_DRIVER'] ?? 'mysql',
        'charset'  => 'utf8',
        'options'  => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false
        ]
    ]
];
