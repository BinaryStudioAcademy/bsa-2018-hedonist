<?php

namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;
use Throwable;

class UserListDeleteDefaultException extends DomainException
{
    public function __construct(
        string $message = 'Can not delete default user list.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
