<?php

namespace Hexlet\Validator;

class NumberValidator extends Validator
{
    public function range(int $from, int $to)
    {
        $this->config->set('range', [$from, $to]);
        return $this;
    }

    public function positive()
    {
        $this->config->set('positive', true);
        return $this;
    }

    public function validateRange($number)
    {
        [$from, $to] = $this->config->get('range');
        return $number >= $from && $number <= $to;
    }

    public function validatePositive($number)
    {
        if ($this->config->get('required') && $number <= 0) {
            return false;
        }

        if (!is_null(($number)) && $number <= 0) {
            return false;
        }

        return true;
    }
}
