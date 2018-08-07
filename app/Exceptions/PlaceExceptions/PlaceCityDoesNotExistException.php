<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceCityDoesNotExistException extends \LogicException
{
    public function __construct(string $message = 'The city does not exists', $code = 404)
    {
        $this->message = $message;
        $this->code = $code;
    }
}