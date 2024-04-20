<?php

namespace Hexlet\Validator;

use Closure;

class CustomValidator
{
    protected string $type;

    protected string $name;

    protected Closure $method;

    public function __construct(string $type, string $name, Closure $method)
    {
        $this->type = $type;
        $this->name = $name;
        $this->method = $method;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function getMethod(): Closure
    {
        return $this->method;
    }

    public function call(mixed ...$args): mixed
    {
        return call_user_func($this->getMethod(), ...$args);
    }
}
