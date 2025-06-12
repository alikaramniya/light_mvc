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

$appName = $_ENV['app_name'] ?? 'mvc';

return [
    'app_name'               => $appName,
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
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
    ],
    'session'                => [
        'name'       => $_ENV['SESSION_NAME'] ?? $appName . '_session',
        'flash_name' => $_ENV['SESSION_FLASH_NAME'] ?? 'flash',
        'secure'     => $_ENV['SESSION_SECURE'] ?? true,
        'httponly'   => $_ENV['SESSION_HTTP_ONLY'] ?? true,
        'samesite'   => $_ENV['SESSION_SAMESITE'] ?? 'lax'
    ]
];
