<?php

declare(strict_types=1);

namespace Test\Domain\Entities;

use Domain\Entities\Error;
use Domain\Entities\User;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testShouldBeHasErrorIfEmailIsInvalid(): void
    {
        $user = new User(null, 'invalid_email.com', 'nickname123', 'secure_password');
        $this->assertTrue($user->hasErrors());
        if ($user->hasErrors()) {
            $handles = array_column($user->getErrors(), 'handle');
            $this->assertContainsEquals('invalid_email', $handles);
        }
    }

    public function testShouldBeHasErrorIfNicknameIsBlank(): void
    {
        $user = new User(null, 'test@email.com', '', 'secure_password');

        $this->assertTrue($user->hasErrors());
        if ($user->hasErrors()) {
            $handles = array_column($user->getErrors(), 'handle');
            $this->assertContains('invalid_nickname', $handles);
        }
    }

    public function testPasswordShouldBeGreaterThen6Characters(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', '12345');

        $this->assertTrue($user->hasErrors());
        if ($user->hasErrors()) {
            $handles = array_column($user->getErrors(), 'handle');
            $this->assertContains('invalid_password', $handles);
        }

        $user2 = new User(null, 'test@email.com', 'nickname123', '123456');

        $this->assertFalse($user2->hasErrors());
    }

    public function testPasswordShouldBeEncrypted(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', 'secure_password');

        $this->assertFalse($user->hasErrors());
        $this->assertTrue(password_verify('secure_password', $user->password));
    }

    public function testCreateNewUserShouldBeWork(): void
    {
        $user = new User(null, 'test@email.com', 'nickname123', 'secure_password');
        $this->assertNull($user->ID);
        $this->assertSame('test@email.com', $user->email);
        $this->assertSame('nickname123', $user->nickname);
        $this->assertTrue(password_verify('secure_password', $user->password));
    }
}
