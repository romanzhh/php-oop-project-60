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

    public function validateRange(int $number): bool
    {
        [$from, $to] = $this->config->get('range');
        return $number >= $from && $number <= $to;
    }

    public function validatePositive(?int $number): bool
    {
        return (!is_null($number) && $number <= 0) ? false : true;
    }
}
