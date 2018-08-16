<?php

namespace Hedonist\Exceptions\Place;

use Hedonist\Exceptions\DomainException;

class PlaceCityDoesNotExistException extends DomainException
{
    public function __construct(string $message = 'The city does not exists', $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}