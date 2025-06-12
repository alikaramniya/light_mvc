<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;

// $containerBuilder->enableCompilation(STORAGE_PATH . '/cache/container');

$containerBuilder->addDefinitions(__DIR__.'/container_bindings.php');

return $containerBuilder->build();
