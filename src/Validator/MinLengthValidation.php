<?php

namespace Hexlet\Validator;

class MinLengthValidation
{
    public function validate($data, $value)
    {
        return strlen($data) >= $value;
    }
}
