<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/Infrastructure/dependencies.php');
$container = $containerBuilder->build();

$app = Bridge::create($container);

$middleware = require_once __DIR__ . '/Presentation/Api/middleware.php';
$middleware($app);

$routes = require_once __DIR__ . '/Presentation/Api/routes.php';
$routes($app);

$app->run();
