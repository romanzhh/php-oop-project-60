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

    public function isValid(?int $number): bool
    {
        $config = $this->config->all();

        if (count($config) === 0) {
            return true;
        }

        $executions = [];

        foreach ($config as $key => $value) {
            switch ($key) {
                case 'required':
                    $executions[] = $value ? is_int($number) : true;
                    break;
                case 'range':
                    [$from, $to] = $value;
                    $executions[] = $number >= $from && $number <= $to;
                    break;
                case 'positive':
                    $required = $config['required'] ?? false;
                    $executions[] = $required ? $number > 0 : is_null($number) || $number > 0;
                    break;
                default:
                    $customValidator = $this->customValidators->getByName($key);
                    $executions[] = $customValidator->call($number, $value);
                    break;
            }
        }

        return !in_array(false, $executions, true);
    }
}
