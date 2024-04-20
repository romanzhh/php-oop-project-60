<?php

namespace Hexlet\Validator;

class ArrayValidator extends Validator
{
    public function shape(array $array): void
    {
        $this->config->set('shape', $array);
    }

    public function sizeof(int $size): static
    {
        $this->config->set('size', $size);
        return $this;
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
                    $executions[] = $value ? is_array($data) : true;
                    break;
                case 'size':
                    $executions[] = sizeof($data ?? []) === $value;
                    break;
                case 'shape':
                    $executions[] = $this->validateShape($data ?? []);
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
