<?php

namespace Domain\UseCases\User;

use Domain\Entities\EntityInterface;
use Infrastructure\Repository\UserRepositoryInterface;

interface UserManagerInterface
{
    public function __construct(UserRepositoryInterface $repository);

    public function getUser(int|string $ID): ?EntityInterface;

    public function findUser(array $filter): array;

    public function createUser(string $email, string $nickname, string $password): EntityInterface;

    public function updateUser(EntityInterface $entity): EntityInterface;

    public function deleteUser(string $ID): bool;
}
