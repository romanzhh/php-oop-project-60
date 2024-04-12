<?php

namespace Hexlet\Validator;

class RequiredValidation
{
    public function validate($data, $value)
    {
        return $value && !empty($data);
    }
}
