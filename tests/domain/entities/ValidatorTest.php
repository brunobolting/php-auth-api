<?php

declare(strict_types=1);

namespace Test\Domain\Entities;

use Domain\Entities\Error;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public function testAddErrorsShouldBeWork(): void
    {
        $validator = new Error();

        $validator->addError('error_message', 'error message', 1);
        $handles = array_column($validator->getErrors(), 'handle');

        $this->assertContainsEquals('error_message', $handles);
    }

    public function testGetErrorsAsStringShouldBeWork(): void
    {
        $validator = new Error();

        $validator->addError('error_message', 'error message', 1);

        $this->assertStringContainsString('error message', $validator->getErrorsAsString());
    }

    public function testHasErrorsShouldBeWork(): void
    {
        $validator = new Error();
        $validator2 = new Error();

        $validator->addError('error_message', 'error message', 1);

        $this->assertTrue($validator->hasErrors());
        $this->assertFalse($validator2->hasErrors());
    }

    public function testGetErrorsShouldBeReturnAllErrorsAsArray(): void
    {
        $validator = new Error();
        $validator2 = new Error();

        $validator->addError('error_message_1', 'error message 1', 1);
        $validator->addError('error_message_2', 'error message 2', 2);
        $validator->addError('error_message_3', 'error message 3', 3);
        $validator->addError('error_message_4', 'error message 4', 4);
        $validator->addError('error_message_5', 'error message 5', 5);

        $this->assertCount(5, $validator->getErrors());
        $this->assertCount(0, $validator2->getErrors());
    }
}
