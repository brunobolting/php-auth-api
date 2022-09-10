<?php

declare(strict_types=1);

namespace Domain\Entities;

/**
 * Class Error
 */
abstract class Error implements ErrorInterface
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
     * @param string $handle
     * @param string $message
     * @param int|null $code
     * @return void
     */
    public function addError(string $handle, string $message, ?int $code = null): void
    {
        $this->errors[] = ['handle' => $handle, 'message' => $message, 'code' => $code];
    }

    /**
     * Verify if has errors
     *
     * @return bool
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
