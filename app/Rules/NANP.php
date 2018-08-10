<?php

namespace Hedonist\Rules;

class NANP extends Phone
{
    public function passes($attribute, $value)
    {
        return $this->isNANP($value);
    }

    public function message()
    {
        return ':attribute must be in the NANP phone format';
    }
}
