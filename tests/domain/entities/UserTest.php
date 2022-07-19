<?php

declare(strict_types=1);

namespace Test\Domain\Entities;

use Domain\Entities\User;
use DomainException;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testShouldBeThrowExceptionIfEmailIsInvalid(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('invalid email');

        $user = new User(null, 'invalid_email.com', 'nickname123', 'secure_password');
    }

    public function testShouldBeThrowExceptionIfNicknameIsBlank(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('invalid nickname');

        $user = new User(null, 'test@email.com', '', 'secure_password');
    }

    public function testShouldBeThrowExceptionIfPasswordHasLessThen6Characters(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('invalid password');

        $user = new User(null, 'test@email.com', 'nickname123', '');
    }

    public function testPasswordShouldBeGreaterThen6Characters(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', 'secure_password');

        $this->assertSame('secure_password', $user->password);
    }

    public function testCreateNewUserShouldBeWork(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', 'secure_password');
        $this->assertNull($user->ID);
        $this->assertSame('test@email.com', $user->email);
        $this->assertSame('nickname123', $user->nickname);
        $this->assertSame('secure_password', $user->password);
    }
}
