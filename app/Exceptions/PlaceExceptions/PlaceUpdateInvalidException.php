<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceUpdateInvalidException extends \LogicException
{
    public function __construct(string $message, $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }
}