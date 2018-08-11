<?php

namespace Hedonist\Exceptions\User;

class UserNotFoundException extends \LogicException
{
    const MESSAGE = 'User NOT found!';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}