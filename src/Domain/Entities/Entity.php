<?php

declare(strict_types=1);

namespace Domain\Entities;

use Ramsey\Uuid\Uuid;

abstract class Entity extends Error implements EntityInterface
{
    public function newID(): int|string
    {
        return (string) Uuid::uuid4();
    }
}
