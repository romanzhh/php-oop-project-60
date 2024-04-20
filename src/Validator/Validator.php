<?php

namespace Hexlet\Validator;

use Closure;

class Validator
{
    protected ValidatorConfig $config;

    protected CustomValidators $customValidators;

    public function __construct(CustomValidators $customValidators = null, ValidatorConfig $config = null)
    {
        $this->customValidators = $customValidators ?? new CustomValidators();
        $this->config = $config ?? new ValidatorConfig();
    }

    public function string(): StringValidator
    {
        return new StringValidator($this->customValidators->forString());
    }

    public function number(): NumberValidator
    {
        return new NumberValidator($this->customValidators->forNumber());
    }

    public function array(): ArrayValidator
    {
        return new ArrayValidator($this->customValidators->forArray());
    }

    public function addValidator(string $type, string $name, Closure $fn): void
    {
        $customValidator = new CustomValidator($type, $name, $fn);
        $this->customValidators->push($customValidator);
    }

    public function test(string $name, mixed $value): static
    {
        $this->config->set($name, $value);
        return $this;
    }

    public function required(): static
    {
        $this->config->set('required', true);
        return $this;
    }
}
