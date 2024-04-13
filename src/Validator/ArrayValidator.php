<?php

namespace Hexlet\Validator;

class ArrayValidator extends Validator
{
    public function sizeof(int $size)
    {
        $this->config->set('size', $size);
        return $this;
    }

    public function validateSize($array)
    {
        return sizeof($array) === $this->config->get('size');
    }

    public function validateRequired($data): bool
    {
        return is_array($data);
    }
}
