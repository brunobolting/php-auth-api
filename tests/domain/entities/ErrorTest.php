<?php

declare(strict_types=1);

namespace Test\Domain\Entities;

use Domain\Entities\Error;
use Domain\Entities\User;
use PHPUnit\Framework\TestCase;

final class ErrorTest extends TestCase
{
    public function testAddErrorsShouldBeWork(): void
    {
        $user = new User(null, 'valid@email.com', 'nickname123', 'secure_password');

        $user->addError('error_message', 'error message', 1);
        $handles = array_column($user->getErrors(), 'handle');

        $this->assertContainsEquals('error_message', $handles);
    }

    public function testGetErrorsAsStringShouldBeWork(): void
    {
        $user = new User(null, 'valid@email.com', 'nickname123', 'secure_password');

        $user->addError('error_message', 'error message', 1);

        $this->assertStringContainsString('error message', $user->getErrorsAsString());
    }

    public function testHasErrorsShouldBeWork(): void
    {
        $user = new User(null, 'valid@email.com', 'nickname123', 'secure_password');
        $user2 = new User(null, 'valid@email.com', 'nickname123', 'secure_password');

        $user->addError('error_message', 'error message', 1);

        $this->assertTrue($user->hasErrors());
        $this->assertFalse($user2->hasErrors());
    }

    public function testGetErrorsShouldBeReturnAllErrorsAsArray(): void
    {
        $user = new User(null, 'valid@email.com', 'nickname123', 'secure_password');
        $user2 = new User(null, 'valid@email.com', 'nickname123', 'secure_password');

        $user->addError('error_message_1', 'error message 1', 1);
        $user->addError('error_message_2', 'error message 2', 2);
        $user->addError('error_message_3', 'error message 3', 3);
        $user->addError('error_message_4', 'error message 4', 4);
        $user->addError('error_message_5', 'error message 5', 5);

        $this->assertCount(5, $user->getErrors());
        $this->assertCount(0, $user2->getErrors());
    }
}
