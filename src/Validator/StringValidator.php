<?php

namespace Hexlet\Validator;

class StringValidator extends Validator
{
    public function minLength(int $length)
    {
        $this->config->set('minLength', $length);
        return $this;
    }

    public function contains(string $str)
    {
        $this->config->set('contains', $str);
        return $this;
    }

    public function validateMinLength($str)
    {
        return strlen($str) >= $this->config->get('minLength');
    }

    public function validateContains($str)
    {
        return str_contains($str, $this->config->get('contains'));
    }
}
