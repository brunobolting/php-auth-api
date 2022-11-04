<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Entities\EntityInterface;
use Domain\Entities\User;

final class UserSQLiteRepository implements UserRepositoryInterface
{
    private \PDO $database;

    public function __construct()
    {
        $this->database = new \PDO('sqlite:' . __DIR__ . '/../../../database/app.db');
        $this->database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function get(int|string $ID): ?EntityInterface
    {
        $query = "SELECT id, email, nickname, password, created_at, updated_at FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->database->prepare($query);
        $stmt->execute([$ID]);
        $entity = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (\count($entity) === 0) {
            return null;
        }

        $entity = (object) $entity[0];

        return new User(
            $entity->id,
            $entity->email,
            $entity->nickname,
            $entity->password,
            new \DateTimeImmutable($entity->created_at),
            new \DateTimeImmutable($entity->updated_at)
        );
    }

    public function find(array $filter = []): array
    {
        $where = [];
        $binds = [];
        foreach ($filter as $key => $value) {
            $where[] = "$key = :$key";
            $binds[":$key"] = $value;
        }
        $where = ' WHERE ' . implode(' and ', $where);
        if (count($filter) === 0) {
            $where = '';
        }
        $query = "SELECT id, email, nickname, password, created_at, updated_at FROM users $where";
        $stmt = $this->database->prepare($query);
        $stmt->execute($binds);
        $entities = $stmt->fetchAll(\PDO::FETCH_OBJ);

        if (\count($entities) === 0) {
            return [];
        }

        $users = [];
        foreach ($entities as $entity) {
            $users[] = new User(
                $entity->id,
                $entity->email,
                $entity->nickname,
                $entity->password,
                new \DateTimeImmutable($entity->created_at),
                new \DateTimeImmutable($entity->updated_at)
            );
        }

        return $users;
    }

    public function create(EntityInterface $entity): bool
    {
        $query = "INSERT INTO users (id, email, nickname, password, created_at, updated_at) 
            VALUES (:id, :email, :nickname, :password, :created_at, :updated_at)";
        $stmt = $this->database->prepare($query);
        $ID = $entity->getID();
        $email = $entity->getEmail();
        $nickname = $entity->getNickname();
        $createdAt = ($entity->getCreatedAt())->format("Y-m-d H:i:s");
        $updatedAt = ($entity->getUpdatedAt())->format("Y-m-d H:i:s");
        $password = $entity->getPassword();

        $stmt->bindParam(':id', $ID, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':nickname', $nickname, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':created_at', $createdAt , \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updatedAt, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update(EntityInterface $entity): bool
    {
        $query = "UPDATE users SET email = :email, nickname = :nickname, password = :password, updated_at = :updated_at 
             WHERE id = :id";
        $stmt = $this->database->prepare($query);
        $ID = $entity->getID();
        $email = $entity->getEmail();
        $nickname = $entity->getNickname();
        $updatedAt = ($entity->getUpdatedAt())->format("Y-m-d H:i:s");
        $password = $entity->getPassword();

        $stmt->bindParam(':id', $ID, \PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, \PDO::PARAM_STR);
        $stmt->bindParam(':nickname', $nickname, \PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, \PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updatedAt, \PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function delete(int|string $ID): bool
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->database->prepare($query);
        return $stmt->execute([$ID]);
    }
}
