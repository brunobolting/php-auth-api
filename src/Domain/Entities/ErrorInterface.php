<?php

namespace Domain\Entities;

interface ErrorInterface
{
    public function getErrors(): array;

    public function addError(string $handle, string $message, ?int $code = null): void;

    public function hasErrors(): bool;

    public function getErrorsAsString(): string;
}
