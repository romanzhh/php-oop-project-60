<?php

namespace Hexlet\Validator\Tests;

use Hexlet\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testStringValidator(): void
    {
        $validator = new Validator();
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
        $this->assertTrue($schema->isValid(null));
        $schema->required();
        $this->assertFalse($schema->isValid(null));
        $this->assertTrue($schema->isValid(7));
        $this->assertTrue($schema->positive()->isValid(10));
        $schema->range(-5, 5);
        $this->assertFalse($schema->isValid(-3));
        $this->assertTrue($schema->isValid(5));
    }

    public function testArrayValidator(): void
    {
        $validator = new \Hexlet\Validator\Validator();
        $schema = $validator->array();
        $this->assertTrue($schema->isValid(null));
        $schema = $schema->required();
        $this->assertTrue($schema->isValid([]));
        $this->assertTrue($schema->isValid(['hexlet']));
        $schema->sizeof(2);
        $this->assertFalse($schema->isValid(['hexlet']));
        $this->assertTrue($schema->isValid(['hexlet', 'code-basics']));
    }

    public function testShapeValidator(): void
    {
        $validator = new Validator();
        $schema = $validator->array();
        $shape = [
            'name' => $validator->string()->required(),
            'age' => $validator->number()->positive(),
        ];
        $schema->shape($shape);
        $this->assertTrue($schema->isValid(['name' => 'kolya', 'age' => 100]));
        $this->assertTrue($schema->isValid(['name' => 'maya', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => '', 'age' => null]));
        $this->assertFalse($schema->isValid(['name' => 'ada', 'age' => -5]));
    }

    public function testCustomValidator(): void
    {
        $validator = new Validator();
        $fn = fn ($value, $start) => str_starts_with($value, $start);
        $validator->addValidator('string', 'startWith', $fn);
        $schema = $validator->string()->test('startWith', 'H')->required();
        $this->assertFalse($schema->isValid('exlet'));
        $this->assertTrue($schema->isValid('Hexlet'));

        $fn = fn ($value, $min) => $value >= $min;
        $validator->addValidator('number', 'min', $fn);
        $schema = $validator->number()->test('min', 5);
        $this->assertFalse($schema->isValid(4));
        $this->assertTrue($schema->isValid(6));
    }
}
