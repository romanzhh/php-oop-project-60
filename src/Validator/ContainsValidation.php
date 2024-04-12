<?php

namespace Hexlet\Validator;

class ContainsValidation
{
    public function validate($data, $value)
    {
        return str_contains($data, $value);
    }
}
