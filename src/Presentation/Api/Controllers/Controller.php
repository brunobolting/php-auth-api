<?php

declare(strict_types=1);

namespace Presentation\Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

abstract class Controller
{
    protected function response(Response $response, int $status, object|array $payload = []): Response
    {
        $payload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
