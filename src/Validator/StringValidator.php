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
                    $executions[] = $value ? !empty($data) : true;
                    break;
                case 'minLength':
                    $executions[] = strlen($data ?? '') >= $value;
                    break;
                case 'contains':
                    $executions[] = str_contains($data ?? '', $value);
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
