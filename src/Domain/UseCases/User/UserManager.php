<?php

declare(strict_types=1);

namespace Domain\UseCases\User;

use Domain\Entities\EntityInterface;
use Domain\Entities\User;
use Infrastructure\Repository\UserRepositoryInterface;

class UserManager implements UserManagerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $repo;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repo = $repository;
    }

    public function getUser(int|string $ID): ?EntityInterface
    {
        return $this->repo->get($ID);
    }

    public function findUser(array $filter): array
    {
        return $this->repo->find($filter);
    }

    public function createUser(string $email, string $nickname, string $password): EntityInterface
    {
        $user = new User(null, $email, $nickname, $password);
        if ($user->hasErrors()) {
            return $user;
        }

        if (!$this->repo->create($user)) {
            $user->addError('error_create', 'error to create user');
        }

        return $user;
    }

    public function updateUser(EntityInterface $entity): EntityInterface
    {
        if ($entity->hasErrors()) {
            return $entity;
        }

        $entity->setUpdatedAt(new \DateTimeImmutable());

        if (!$this->repo->update($entity)) {
            $entity->addError('error_update', 'error to update user');
        }
        return $entity;
    }

    public function deleteUser(int|string $ID): bool
    {
        return $this->repo->delete($ID);
    }
}
