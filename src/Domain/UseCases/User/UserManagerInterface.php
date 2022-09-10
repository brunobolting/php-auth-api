<?php

namespace Domain\UseCases\User;

use Domain\Entities\EntityInterface;
use Infrastructure\Repository\Repository;

interface UserManagerInterface
{
    public function __construct(Repository $repository);

    public function getUser(int|string $ID): ?EntityInterface;

    public function findUser(array $filter): array;

    public function createUser(string $email, string $nickname, string $password): EntityInterface;

    public function updateUser(EntityInterface $entity): EntityInterface;

    public function deleteUser(string $ID): bool;
}
