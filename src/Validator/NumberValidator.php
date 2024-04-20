<?php

namespace Hexlet\Validator;

class NumberValidator extends Validator
{
    public function range(int $from, int $to): static
    {
        $this->config->set('range', [$from, $to]);
        return $this;
    }

    public function positive(): static
    {
        $this->config->set('positive', true);
        return $this;
    }

    public function isValid(mixed $data): bool
    {
        $config = $this->config->all();

        if (empty($config)) {
            return true;
        }

        $executions = [];

        foreach ($config as $key => $value) {
            switch ($key) {
                case 'required':
                    $executions[] = $value ? is_int($data) : true;
                    break;
                case 'range':
                    [$from, $to] = $value;
                    $executions[] = $data >= $from && $data <= $to;
                    break;
                case 'positive':
                    $required = $config['required'] ?? false;
                    $executions[] = $required ? $data > 0 : is_null($data) || $data > 0;
                    break;
                default:
                    $customValidator = $this->customValidators->getByName($key);
                    $executions[] = $customValidator->call($data, $value);
                    break;
            }
        }

        return !in_array(false, $executions);
    }
}
