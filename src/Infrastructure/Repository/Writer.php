<?php

namespace Infrastructure\Repository;

use Domain\Entities\EntityInterface;

interface Writer
{
    public function create(EntityInterface $entity): ?EntityInterface;

    public function update(EntityInterface $entity): ?EntityInterface;

    public function delete(int|string $ID): bool;
}
