<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/infrastructure/dependencies.php');
$container = $containerBuilder->build();

$app = Bridge::create($container);

require __DIR__ . '/presentation/api/routes.php';

$app->run();
