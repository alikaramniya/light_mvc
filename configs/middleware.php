<?php

use App\Core\Config;
use Psr\Container\ContainerInterface;
use Slim\App;

return function (App $app, ContainerInterface $container) {
    $config = $container->get(Config::class);

    $app->addErrorMiddleware(
        (bool) $config->get('display_error'),
        (bool) $config->get('error_reporting'),
        (bool) $config->get('error_reporting_details')
    );
};
