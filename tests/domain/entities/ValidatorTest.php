<?php

declare(strict_types=1);

namespace Test\Domain\Entities;

use Domain\Entities\Validator;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public function testAddErrorsShouldBeWork(): void
    {
        $validator = new Validator();
        $validator->addError('error message');

        $this->assertContainsEquals('error message', $validator->getErrors());
    }

    public function testGetErrorsAsStringShouldBeWork(): void
    {
        $validator = new Validator();
        $validator->addError('error message');

        $this->assertStringContainsString('error message', $validator->getErrorsAsString());
    }

    public function testHasErrorsShouldBeWork(): void
    {
        $validator = new Validator();
        $validator->addError('error message');

        $validator2 = new Validator();

        $this->assertTrue($validator->hasErrors());
        $this->assertFalse($validator2->hasErrors());
    }

    public function testGetErrorsShouldBeReturnAllErrorsAsArray(): void
    {
        $validator = new Validator();
        $validator->addError('error message 1');
        $validator->addError('error message 2');
        $validator->addError('error message 3');
        $validator->addError('error message 4');
        $validator->addError('error message 5');

        $validator2 = new Validator();

        $this->assertCount(5, $validator->getErrors());
        $this->assertCount(0, $validator2->getErrors());
    }
}
