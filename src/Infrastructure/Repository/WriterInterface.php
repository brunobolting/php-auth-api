<?php

namespace Infrastructure\Repository;

use Domain\Entities\EntityInterface;

interface WriterInterface
{
    public function create(EntityInterface $entity): bool;

    public function update(EntityInterface $entity): bool;

    public function delete(int|string $ID): bool;
}
