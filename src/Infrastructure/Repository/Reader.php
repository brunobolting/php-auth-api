<?php

namespace Infrastructure\Repository;

use Domain\Entities\EntityInterface;

interface Reader
{
    public function get(int|string $ID): ?EntityInterface;

    public function find(array $filter): array;
}
