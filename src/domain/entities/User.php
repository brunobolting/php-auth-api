<?php

declare(strict_types=1);

namespace Domain\Entities;

use DateTimeImmutable;
use DateTimeInterface;
use Domain\Entities\Validator;
use DomainException;

/**
 * Class User
 */
final class User
{
    /**
     * @var integer|null
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
     * @var \DateTimeInterface
     */
    public DateTimeInterface $createdOn;

    /**
     * @var \DateTimeInterface
     */
    public DateTimeInterface $updatedOn;

    /**
     * User construct
     *
     * @param integer|null $ID
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

        $validation = $this->validate();
        if ($validation->hasErrors()) {
            throw new DomainException($validation->getErrorsAsString());
        }
    }

    /**
     * Validate User Entity
     *
     * @return \Domain\Entities\Validator
     */
    private function validate(): Validator
    {
        $errors = new Validator();

        if (!\filter_var($this->email, \FILTER_VALIDATE_EMAIL)) {
            $errors->addError("invalid email");
        }

        if (\strlen(\trim($this->nickname)) === 0) {
            $errors->addError("invalid nickname, cannot be blank");
        }

        if (\strlen(\trim($this->password)) < 6) {
            $errors->addError("invalid password, should be greater than 6 characters");
        }


        return $errors;
    }
}
