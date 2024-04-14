<?php

namespace Hexlet\Validator;

class ArrayValidator extends Validator
{
    public function shape(array $array)
    {
        $this->config->set('shape', $array);
    }

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
        return $this->config->get('required') ? is_array($data) : true;
    }

    public function validateShape(array $array): bool
    {
        $shape = $this->config->get('shape');

        foreach ($array as $key => $value) {
            $validator = $shape[$key];
            if (!$validator->isValid($value)) {
                return false;
            }
        }

        return true;
    }
}
