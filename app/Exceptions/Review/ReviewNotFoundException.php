<?php

namespace Hedonist\Exceptions\Review;

class ReviewNotFoundException extends \LogicException
{
    const MESSAGE = 'Review NOT found';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}
