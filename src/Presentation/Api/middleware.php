<?php

declare(strict_types=1);

use BrunoBolting\AuthApi\Domain\Entities\SecretKeyInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Tuupola\Middleware\JwtAuthentication;

return function (App $app)
{
    $app->addRoutingMiddleware();
    $app->add(new JwtAuthentication([
        "ignore" => ["ping", "/auth/login", "/auth/register"],
        "secret" => SecretKeyInterface::JWT_SECRET_KEY,
        "error" => function (ResponseInterface $response, array $arguments) {
            $payload = [
                'error' => str_replace('.', '', strtolower($arguments['message']))
            ];
            $payload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(401);
        }
    ]));
    $app->addErrorMiddleware(true, true, true);
};
