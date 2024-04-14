<?php

namespace Hexlet\Validator;

class Validator
{
    public const STRING_TYPE = 'string';

    public const NUMBER_TYPE = 'number';

    public const ARRAY_TYPE = 'array';

    /**
     * @var ValidatorConfig
     */
    protected $config;

    protected $customValidators;

    public function __construct($customValidators = null, $config = null)
    {
        $this->customValidators = $customValidators ?? [];
        $this->config = $config ?? new ValidatorConfig();
        $this->config->set('required', false);
    }

    public function string()
    {
        return new StringValidator(
            $this->customValidators[self::STRING_TYPE] ?? []
        );
    }

    public function number()
    {
        return new NumberValidator(
            $this->customValidators[self::NUMBER_TYPE] ?? []
        );
    }

    public function array()
    {
        return new ArrayValidator(
            $this->customValidators[self::ARRAY_TYPE] ?? []
        );
    }

    public function addValidator(string $type, string $name, callable $fn)
    {
        $name = 'validate' . ucfirst($name);
        $this->customValidators[$type][$name] = $fn;
    }

    public function test($name, $value)
    {
        $this->config->set($name, $value);
        return $this;
    }

    public function required()
    {
        $this->config->set('required', true);
        return $this;
    }

    public function validateRequired($data): bool
    {
        return $this->config->get('required') ? !empty($data) : true;
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

        $class_methods = get_class_methods($this);
        $custom_methods = array_diff($methods, $class_methods);
        $base_methods = array_diff($methods, $custom_methods);

        $exec = array_map(
            fn ($method) => $this->customValidators[$method](
                $data,
                $config[lcfirst(str_replace('validate', '', $method))]
            ),
            $custom_methods
        );

        $exec = array_merge($exec, array_map(
            fn ($method) => $this->$method($data),
            $base_methods
        ));

        return !in_array(false, $exec);
    }
}
