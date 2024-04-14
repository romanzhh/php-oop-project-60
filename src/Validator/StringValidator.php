<?php

namespace Hexlet\Validator;

class StringValidator extends Validator
{
    public function minLength(int $length): static
    {
        $this->config->set('minLength', $length);
        return $this;
    }

    public function contains(string $str): static
    {
        $this->config->set('contains', $str);
        return $this;
    }

    public function validateMinLength(string $str): bool
    {
        return strlen($str) >= $this->config->get('minLength');
    }

    public function validateContains(string $str): bool
    {
        return str_contains($str, $this->config->get('contains'));
    }
}
