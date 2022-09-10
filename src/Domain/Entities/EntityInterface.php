<?php

namespace Domain\Entities;

interface EntityInterface extends ErrorInterface
{
    public function newID(): int|string;
}
