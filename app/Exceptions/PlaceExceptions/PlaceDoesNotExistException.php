<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceDoesNotExistException extends AbstractPlaceException
{
    public function __construct($message = 'The place does not exists', $code = 404)
    {
        $this->message = $message;
        $this->code = $code;
    }
}