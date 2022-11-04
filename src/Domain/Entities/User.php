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
    private readonly ?string $ID;

    /**
     * @param string $email
     */

    /**
     * @var string
     */
    private string $email;

    /**
     * @var string
     */
    private string $nickname;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $createdAt;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $updatedAt;

    /**
     * User construct
     *
     * @param string|null $ID
     * @param string $email
     * @param string $nickname
     * @param string $password
     */
    public function __construct(
        ?string $ID,
        string $email,
        string $nickname,
        string $password,
        DateTimeInterface $createdAt = new DateTimeImmutable(),
        DateTimeInterface $updatedAt = new DateTimeImmutable()
    ) {
        if ($ID !== null) {
            $this->validateID($ID);
        }
        $this->validateEmail($email);
        $this->validateNickname($nickname);
        $this->validatePassword($password);

        $this->ID = $ID ?? $this->newID();
        $this->email = $email;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->password = $this->hashPassword($password);
    }

//    /**
//     * Validate User EntityInterface
//     *
//     * @return void
//     */
//    public function validate(): void
//    {
//        $this->validateID();
//
//        $this->validateEmail();
//
//        $this->validateNickname();
//
//        $this->validatePassword();
//    }

    public function setEmail(string $email): void
    {
        if (!$this->validateEmail($email)) {
            return;
        }
        $this->email = $email;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname): void
    {
        if (!$this->validateNickname($nickname)) {
            return;
        }
        $this->nickname = $nickname;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        if (!$this->validatePassword($password)) {
            return;
        }

        $this->password = $this->hashPassword($password);
    }

    /**
     * @param DateTimeInterface $updatedAt
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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

    /**
     * @return string|null
     */
    public function getID(): ?string
    {
        return $this->ID;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * get user password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function validateID(int|string $ID): bool
    {
        if ($ID === null) {
            $this->addError("invalid_id", "invalid id, cannot be blank", 1);
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validateEmail(string $email): bool
    {
        if (!\filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            $this->addError("invalid_email", "invalid email", 2);
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validateNickname(string $nickname): bool
    {
        if (\strlen(\trim($nickname)) === 0) {
            $this->addError("invalid_nickname", "invalid nickname, cannot be blank", 3);
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        if (\strlen(\trim($password)) < 6) {
            $this->addError(
                "invalid_password",
                "invalid password, should be greater than 6 characters",
                3
            );
            return false;
        }

        return true;
    }
}
