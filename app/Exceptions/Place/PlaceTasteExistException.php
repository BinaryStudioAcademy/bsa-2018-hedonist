<?php

namespace Hedonist\Exceptions\Place;

use Hedonist\Exceptions\DomainException;

class PlaceTasteExistException extends DomainException
{
    public function __construct(string $message = 'This place already has this taste', $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}