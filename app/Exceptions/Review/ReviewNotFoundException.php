<?php

namespace Hedonist\Exceptions\Review;

use Hedonist\Exceptions\DomainException;

class ReviewNotFoundException extends DomainException
{
    const MESSAGE = 'Review NOT found';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}
