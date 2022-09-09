<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;
use DateTimeInterface;
use Domain\Entities\Error;
use DomainException;

/**
 * Class User
 */
final class User
{
    /**
     * @var int|null
     */
    public ?int $ID;

    /**
     * @var string
     */
    public string $email;

    /**
     * @var string
     */
    public string $nickname;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var DateTimeInterface
     */
    public DateTimeInterface $createdOn;

    /**
     * @var DateTimeInterface
     */
    public DateTimeInterface $updatedOn;

    /**
     * @var \Domain\Entities\Error|null
     */
    public ?Error $error;

    /**
     * User construct
     *
     * @param int|null $ID
     * @param string $email
     * @param string $nickname
     * @param string $password
     */
    public function __construct(?int $ID, string $email, string $nickname, string $password)
    {
        $this->ID = $ID;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->createdOn = new DateTimeImmutable();
        $this->updatedOn = new DateTimeImmutable();

        $this->error = $this->validate();

        $this->password = $this->hashPassword($password);
    }

    /**
     * Validate User Entity
     *
     * @return Error|null
     */
    private function validate(): ?Error
    {
        $errors = new Error();

        if (!\filter_var($this->email, \FILTER_VALIDATE_EMAIL)) {
            $errors->addError("invalid_email", "invalid email", 1);
        }

        if (\strlen(\trim($this->nickname)) === 0) {
            $errors->addError("invalid_nickname", "invalid nickname, cannot be blank", 2);
        }

        if (\strlen(\trim($this->password)) < 6) {
            $errors->addError(
                "invalid_password",
                "invalid password, should be greater than 6 characters",
                3
            );
        }

        if (!$errors->hasErrors()) {
            return null;
        }

        return $errors;
    }

    /**
     * Hash User password
     *
     * @param string $password
     * @return string
     */
    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2I);
    }
}
