<?php

namespace Hedonist\Rules;

class E164 extends Phone
{
    public function passes($attribute, $value)
    {
        return $this->isE164($value);
    }

    public function message()
    {
        return ':attribute must be in E.164 phone format';
    }
}
