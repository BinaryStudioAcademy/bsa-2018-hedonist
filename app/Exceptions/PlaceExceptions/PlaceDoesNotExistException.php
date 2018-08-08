<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceDoesNotExistException extends \LogicException
{
    public function __construct(string $message = 'The place does not exists', $code = 404)
    {
        $this->message = $message;
        $this->code = $code;
    }
}