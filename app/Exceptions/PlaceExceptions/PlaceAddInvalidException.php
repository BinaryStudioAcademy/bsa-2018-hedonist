<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceAddInvalidException extends \LogicException
{
    public function __construct(string $message, $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }
}