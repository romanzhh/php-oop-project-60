<?php

namespace Hexlet\Validator;

class Validator
{
    /**
     * @var ValidatorConfig
     */
    protected $config;

    public function __construct()
    {
        $this->config = new ValidatorConfig();
    }

    public function string()
    {
        return new StringValidator();
    }

    public function number()
    {
        return new NumberValidator();
    }

    public function array()
    {
        return new ArrayValidator();
    }

    public function addValidator(string $type, string $name, callable $fn)
    {
    }

    public function test($name, $value)
    {
        $this->config->get($name);
        return $this;
    }

    public function required()
    {
        $this->config->set('required', true);
        return $this;
    }

    public function validateRequired($data): bool
    {
        return !empty($data);
    }

    public function isValid($data): bool
    {
        $config = $this->config->all();

        if (!$config) {
            return true;
        }

        $methods = array_map(
            fn ($name) => ('validate' . ucfirst($name)),
            array_keys($config)
        );

        $exec = array_map(
            fn ($method) => $this->$method($data),
            $methods
        );

        return !in_array(false, $exec);
    }
}
