<?php

namespace Hedonist\Exceptions\User;

use Hedonist\Exceptions\DomainException;

class UserNotFoundException extends DomainException
{
    const MESSAGE = 'User NOT found!';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}