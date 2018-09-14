<?php

namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;

class UserListExistsException extends DomainException
{
    const MESSAGE = 'User list not found.';

    public static function create(): self
    {
        return new self(self::MESSAGE);
    }
}