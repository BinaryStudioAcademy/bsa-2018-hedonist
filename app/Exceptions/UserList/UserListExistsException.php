<?php

namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;
use Throwable;

class UserListExistsException extends DomainException
{
    public function __construct(string $message = 'User list not found.', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}