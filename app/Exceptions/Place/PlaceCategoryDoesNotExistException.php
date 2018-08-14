<?php

namespace Hedonist\Exceptions\Place;

use Hedonist\Exceptions\DomainException;

class PlaceCategoryDoesNotExistException extends DomainException
{
    public function __construct(string $message = 'The category does not exists', $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}