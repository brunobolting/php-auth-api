<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * Class User
 */
final class User extends Entity
{
    /**
     * @var string|null
     */
    public readonly ?string $ID;

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
     * User construct
     *
     * @param string|null $ID
     * @param string $email
     * @param string $nickname
     * @param string $password
     */
    public function __construct(?string $ID, string $email, string $nickname, string $password)
    {
        $this->ID = $ID ?? $this->newID();
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->createdOn = new DateTimeImmutable();
        $this->updatedOn = new DateTimeImmutable();

        $this->validate();

        $this->password = $this->hashPassword($password);
    }

    /**
     * Validate User EntityInterface
     *
     * @return void
     */
    public function validate(): void
    {
        if ($this->ID === null) {
            $this->addError("invalid_id", "invalid id, cannot be blank", 1);
        }

        if (!\filter_var($this->email, \FILTER_VALIDATE_EMAIL)) {
            $this->addError("invalid_email", "invalid email", 2);
        }

        if (\strlen(\trim($this->nickname)) === 0) {
            $this->addError("invalid_nickname", "invalid nickname, cannot be blank", 3);
        }

        if (\strlen(\trim($this->password)) < 6) {
            $this->addError(
                "invalid_password",
                "invalid password, should be greater than 6 characters",
                3
            );
        }
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
