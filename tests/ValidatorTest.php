<?php

namespace Hexlet\Validator\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testStringValidator(): void
    {
        $validator = new Validator();
        dd($validator->string()->number());
        $schema = $validator->string()->required();
        $this->assertTrue($schema->isValid('string'));
        $this->assertFalse($schema->isValid(''));
        $this->assertTrue($schema->contains('str')->isValid('string'));
        $this->assertFalse($schema->contains('str')->isValid('array'));
    }

    public function testNumberValidator(): void
    {
        $validator = new Validator();
        $schema = $validator->number();
        $this->assertTrue($schema->isValid(3));
    }

    public function testArrayValidator(): void
    {
        $validator = new Validator();
        $schema = $validator->array();
        $this->assertTrue($schema->required()->sizeof(3)->isValid([1, 2, 3]));
        $this->assertFalse($schema->sizeof(3)->isValid([1, 2]));
    }
}
