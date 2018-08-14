<?php

namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;

class UserListNotFoundException extends DomainException
{
    public function __construct(string $message = 'The userlist does not exists', $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
