<?php

use App\Core\Config;
use App\Core\DB;
use Dotenv\Dotenv;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Slim\App;

use function DI\create;

return [
    App::class => function (ContainerInterface $container) {
        $router     = require CONFIG_PATH . '/routes/web.php';
        $middleware = require CONFIG_PATH . '/middleware.php';

        AppFactory::setContainer($container);

        $app = AppFactory::create();

        $router($app);

        $middleware($app, $container);

        return $app;
    },
    Config::class      => create(Config::class)->constructor(require CONFIG_PATH . '/app.php'),
    PhpRenderer::class => create(PhpRenderer::class)->constructor(VIEW_PATH),
    DB::class          => fn(Config $config) => new DB($config),
];
