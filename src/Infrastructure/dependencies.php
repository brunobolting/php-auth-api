<?php

declare(strict_types=1);

use Domain\UseCases\User\UserManager;
use Domain\UseCases\User\UserManagerInterface;
use Infrastructure\Repository\UserRepositoryInterface;
use Infrastructure\Repository\UserSQLiteRepository;

return [
    UserRepositoryInterface::class => DI\Create(UserSQLiteRepository::class),
    UserManagerInterface::class => DI\Create(UserManager::class)
        ->constructor(DI\get(UserRepositoryInterface::class))
];
