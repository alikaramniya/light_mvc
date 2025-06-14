<?php

use App\Contracts\AuthInterface;
use App\Contracts\RequestValidatorFactoryInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserProviderServiceInterface;
use App\Core\Auth;
use App\Core\Config;
use App\Core\DB;
use App\Core\RequestValidator;
use App\Core\Session;
use App\DataObjects\SessionConfig;
use App\Enums\SameSite;
use App\Services\UserProviderService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Csrf\Guard;
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
    Config::class                           => create(Config::class)->constructor(require CONFIG_PATH . '/app.php'),
    PhpRenderer::class                      => create(PhpRenderer::class)->constructor(VIEW_PATH),
    DB::class                               => fn(Config $config) => new DB($config),
    ResponseFactoryInterface::class         => fn(App $app) => $app->getResponseFactory(),
    AuthInterface::class                    => fn(ContainerInterface $container) => $container->get(Auth::class),
    UserProviderServiceInterface::class     => fn(ContainerInterface $container) => $container->get(UserProviderService::class),
    SessionInterface::class                 => fn(Config $config) => new Session(new SessionConfig(
        $config->get('session.name'),
        $config->get('session.flash_name'),
        $config->get('session.secure'),
        $config->get('session.httponly'),
        SameSite::tryFrom($config->get('session.samesite'))
    )),
    RequestValidatorFactoryInterface::class => fn(ContainerInterface $container) => $container->get(
        RequestValidator::class
    ),
    'csrf'                                  => fn(ResponseFactoryInterface $responseFactory) => new Guard($responseFactory, persistentTokenMode: true),
];
