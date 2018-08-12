<?php

namespace Hedonist\Exceptions\Place;

use Hedonist\Exceptions\DomainException;

class PlaceNotFoundException extends DomainException
{
    public function __construct(string $message = 'The place does not exists', $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
