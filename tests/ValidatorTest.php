<?php

namespace Hexlet\Validator\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testValidator(): void
    {
        $validator = new Validator();
        $schema = $validator->required()->minLength(6);
        $this->assertTrue($schema->isValid('string'));
        $this->assertFalse($schema->isValid(''));
        $this->assertTrue($schema->contains('str')->isValid('string'));
        $this->assertFalse($schema->contains('str')->isValid('array'));
    }
}
