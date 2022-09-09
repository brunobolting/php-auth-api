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
final class User extends Error implements Entity
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

        $this->validate();

        $this->password = $this->hashPassword($password);
    }

    /**
     * Validate User Entity
     *
     * @return void
     */
    public function validate(): void
    {
        if (!\filter_var($this->email, \FILTER_VALIDATE_EMAIL)) {
            $this->addError("invalid_email", "invalid email", 1);
        }

        if (\strlen(\trim($this->nickname)) === 0) {
            $this->addError("invalid_nickname", "invalid nickname, cannot be blank", 2);
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
