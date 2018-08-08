<?php

namespace Hedonist\Exceptions\Place;

use LogicException;

class PlaceNotFoundException extends LogicException
{
    public function __construct(string $message = 'The place does not exists', $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
