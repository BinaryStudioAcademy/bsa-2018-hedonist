<?php

namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;

class UserListPermissionDeniedException extends DomainException
{
    public function __construct($message = 'You have no permissions for the action', $code = 403)
    {
        parent::__construct($message, $code);
    }
}
