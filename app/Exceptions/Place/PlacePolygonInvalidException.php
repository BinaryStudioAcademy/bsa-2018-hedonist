<?php

namespace Hedonist\Exceptions\Place;

use Hedonist\Exceptions\DomainException;

class PlacePolygonInvalidException extends DomainException
{
    public static function createFromMessage($message): self
    {
        return new self($message);
    }
}