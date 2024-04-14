<?php

namespace Hexlet\Validator;

class ValidatorConfig
{
    /**
     * @var array
     */
    protected $data;

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key];
    }

    public function all(): array
    {
        return $this->data;
    }
}
