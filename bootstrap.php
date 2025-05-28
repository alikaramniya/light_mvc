<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/configs/path_constants.php';

Dotenv::createImmutable(ROOT_PATH)->load();

return require CONFIG_PATH . '/container/container.php';
