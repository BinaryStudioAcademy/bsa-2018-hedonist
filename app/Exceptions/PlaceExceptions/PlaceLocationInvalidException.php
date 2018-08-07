<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceLocationInvalidException extends \LogicException
{
    public function __construct(string $message, $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }
}