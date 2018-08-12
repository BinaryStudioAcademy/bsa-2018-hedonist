<?php

namespace Hedonist\Rules;

use Illuminate\Contracts\Validation\Rule;

class Phone implements Rule
{
    public function passes($attribute, $value)
    {
        return $this->isPhone($value);
    }

    public function message()
    {
        return 'Incorrect phone format for :attribute.';
    }

    /**
     * Checks through all validation methods to verify it is in a
     * phone number format of some type.
     */
    protected function isPhone($value)
    {
        return $this->isE164($value) || $this->isNANP($value) || $this->isDigits($value);
    }

    /**
     * Format example 5555555555, 15555555555.
     */
    protected function isDigits($value)
    {
        $conditions = [];
        $conditions[] = strlen($value) >= 10;
        $conditions[] = strlen($value) <= 16;
        $conditions[] = preg_match("/[^\d]/i", $value) === 0;

        return (bool) array_product($conditions);
    }

    /**
     * Format example +15555555555.
     */
    protected function isE164($value)
    {
        $conditions = [];
        $conditions[] = strpos($value, '+') === 0;
        $conditions[] = strlen($value) >= 9;
        $conditions[] = strlen($value) <= 16;
        $conditions[] = preg_match("/[^\d+]/i", $value) === 0;

        return (bool) array_product($conditions);
    }

    /**
     * Format examples: (555) 555-5555, 1 (555) 555-5555, 1-555-555-5555, 555-555-5555, 1 555 555-5555.
     */
    protected function isNANP($value)
    {
        $conditions = [];
        $conditions[] = preg_match("/^(?:\+1|1)?\s?-?\(?\d{3}\)?(\s|-)?\d{3}-\d{4}$/i", $value) > 0;

        return (bool) array_product($conditions);
    }
}
