<?php

namespace Hexlet\Validator;

use Hexlet\Validator\ContainsValidation;
use Hexlet\Validator\MinLengthValidation;
use Hexlet\Validator\RequiredValidation;

class Validator
{
    protected $config;

    protected static $validations = [
        'contains' => ContainsValidation::class,
        'required' => RequiredValidation::class,
        'min_length' => MinLengthValidation::class
    ];

    public function __construct(array $config = [])
    {
        $this->config = $config;
        $this->initValidators();
    }

    public function initValidators()
    {
        array_walk(
            self::$validations,
            fn ($val, $key) => $this->$key = new $val()
        );
    }

    public function string()
    {
        return new static(array_merge([
            'type' => 'string'
        ], $this->config));
    }

    public function required()
    {
        return new static(array_merge([
            'required' => true
        ], $this->config));
    }

    public function minLength(int $length)
    {
        return new static(array_merge([
            'min_length' => $length
        ], $this->config));
    }

    public function contains(string $str)
    {
        return new static(array_merge([
            'contains' => $str
        ], $this->config));
    }

    public function isValid($data): bool
    {
        foreach ($this->config as $name => $value) {
            $validator = $this->$name;
            if (!$validator->validate($data, $value)) {
                return false;
            }
        }

        return true;
    }
}
