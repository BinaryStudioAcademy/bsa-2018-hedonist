<?php

namespace Hedonist\Exceptions\PlaceExceptions;


use Hedonist\Exceptions\DomainException;

class PlaceLocationInvalidException extends DomainException
{
    public function __construct(string $message, $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}