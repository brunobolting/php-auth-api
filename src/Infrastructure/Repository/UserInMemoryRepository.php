<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Domain\Entities\EntityInterface;

final class UserInMemoryRepository implements Repository
{
    /**
     * @var array
     */
    private array $inmem;

    public function get(int|string $ID): ?EntityInterface
    {
        return $this->inmem[$ID] ?? null;
    }

    public function find(array $filter): array
    {
        $entities = [];

        foreach ($this->inmem as $ID => $entity) {
            foreach ($filter as $field => $value) {
                if ($entity->$field === $value) {
                    $entities[] = $entity;
                }
            }
        }

        return $entities;
    }

    public function create(EntityInterface $entity): ?EntityInterface
    {
        $this->inmem[$entity->ID] = $entity;
        return $this->inmem[$entity->ID];
    }

    public function update(EntityInterface $entity): ?EntityInterface
    {
        $elem = $this->get($entity->ID);
        if ($elem === null) {
            return null;
        }

        $this->inmem[$elem->ID] = $entity;

        return $this->inmem[$elem->ID];
    }

    public function delete(int|string $ID): bool
    {
        unset($this->inmem[$ID]);

        return !isset($this->inmem[$ID]);
    }
}
