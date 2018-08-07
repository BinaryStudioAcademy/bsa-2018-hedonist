<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceCreatorDoesNotExistException extends \LogicException
{
    public function __construct(string $message = 'The user does not exists', $code = 404)
    {
        $this->message = $message;
        $this->code = $code;
    }
}