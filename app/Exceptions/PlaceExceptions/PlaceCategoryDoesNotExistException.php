<?php

namespace Hedonist\Exceptions\PlaceExceptions;


class PlaceCategoryDoesNotExistException extends \LogicException
{
    public function __construct(string $message = 'The category does not exists', $code = 404)
    {
        $this->message = $message;
        $this->code = $code;
    }
}