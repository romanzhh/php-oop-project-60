<?php

namespace Hexlet\Validator;

class ValidatorConfig
{
    protected $data;

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function all()
    {
        return $this->data;
    }
}
