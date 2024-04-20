<?php

namespace Hexlet\Validator;

class StringValidator extends Validator
{
    public function minLength(int $length): static
    {
        $this->config->set('minLength', $length);
        return $this;
    }

    public function contains(string $str): static
    {
        $this->config->set('contains', $str);
        return $this;
    }

    public function isValid(?string $str): bool
    {
        $config = $this->config->all();

        if (count($config) === 0) {
            return true;
        }

        $str = $str ?? '';

        $executions = [];

        foreach ($config as $key => $value) {
            switch ($key) {
                case 'required':
                    $executions[] = $value ? strlen($str) !== 0 : true;
                    break;
                case 'minLength':
                    $executions[] = strlen($str) >= $value;
                    break;
                case 'contains':
                    $executions[] = str_contains($str, $value);
                    break;
                default:
                    $customValidator = $this->customValidators->getByName($key);
                    $executions[] = $customValidator->call($str, $value);
                    break;
            }
        }

        return !in_array(false, $executions, true);
    }
}
