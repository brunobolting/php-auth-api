<?php

declare(strict_types=1);

namespace Test\Domain\Entities;

use Domain\Entities\User;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class UserTest extends TestCase
{
    public function testIDShouldBeValid(): void
    {
        $user = new User(null, 'valid@email.com', 'nickname123', 'secure_password');
        $this->assertNotNull($user->getID());
        $this->assertTrue(Uuid::isValid($user->getID()));
    }

    public function testShouldBeHasErrorIfEmailIsInvalid(): void
    {
        $user = new User(null, 'invalid_email.com', 'nickname123', 'secure_password');
        $this->assertTrue($user->hasErrors());
        if ($user->hasErrors()) {
            $this->assertArrayHasKey('invalid_email', $user->getErrors());
        }
    }

    public function testShouldBeHasErrorIfNicknameIsBlank(): void
    {
        $user = new User(null, 'test@email.com', '', 'secure_password');

        $this->assertTrue($user->hasErrors());
        if ($user->hasErrors()) {
            $this->assertArrayHasKey('invalid_nickname', $user->getErrors());
        }
    }

    public function testPasswordShouldBeGreaterThen6Characters(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', '12345');

        $this->assertTrue($user->hasErrors());
        if ($user->hasErrors()) {
            $this->assertArrayHasKey('invalid_password', $user->getErrors());
        }

        $user2 = new User(null, 'test@email.com', 'nickname123', '123456');

        $this->assertFalse($user2->hasErrors());
    }

    public function testPasswordShouldBeEncrypted(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', 'secure_password');

        $this->assertFalse($user->hasErrors());
        $this->assertTrue(password_verify('secure_password', $user->getPassword()));
    }

    public function testCreateNewUserShouldBeWork(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', 'secure_password');
        $this->assertNotNull($user->getID());
        $this->assertSame('test@email.com', $user->getEmail());
        $this->assertSame('nickname123', $user->getNickname());
        $this->assertTrue(password_verify('secure_password', $user->getPassword()));
    }
}
