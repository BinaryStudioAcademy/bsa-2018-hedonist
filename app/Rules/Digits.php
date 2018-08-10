<?php

namespace Hedonist\Rules;

class Digits extends Phone
{
    public function passes($attribute, $value)
    {
        return $this->isDigits($value);
    }

    public function message()
    {
        return ':attribute must be in digits only format';
    }
}
