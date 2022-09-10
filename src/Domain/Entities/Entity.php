<?php

namespace Domain\Entities;

use Ramsey\Uuid\Uuid;

abstract class Entity extends Error implements EntityInterface
{
    public function newID(): int|string
    {
        return Uuid::uuid4();
    }
}
