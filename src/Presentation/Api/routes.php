<?php

use Presentation\Api\Controllers\UserController;
use Slim\App;

return function (App $app)
{
    $app->post('/users', [UserController::class, 'create']);
    $app->get('/users/{id}', [UserController::class, 'get']);
    $app->put('/users/{id}', [UserController::class, 'update']);
    $app->delete('/users/{id}', [UserController::class, 'delete']);
    $app->get('/users', [UserController::class, 'list']);
    $app->get('/ping', [UserController::class, 'ping']);
};
