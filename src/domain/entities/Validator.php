<?php

declare(strict_types=1);

namespace Domain\Entities;

/**
 * Class Error
 */
final class Validator
{
    /**
     * @var array
     */
    private array $errors = [];

    /**
     * Get Errors as Array
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Add new Error Message
     *
     * @param string $message
     *
     * @return void
     */
    public function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * Verify if has errors
     *
     * @return boolean
     */
    public function hasErrors(): bool
    {
        return \count($this->errors) !== 0;
    }

    /**
     * Get Errors as String
     *
     * @return string
     */
    public function getErrorsAsString(): string
    {
        return \json_encode($this->errors);
    }
}
