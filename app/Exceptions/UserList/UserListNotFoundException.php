<?php

namespace Hedonist\Exceptions\UserList;

use LogicException;

class UserListNotFoundException extends LogicException
{
    public function __construct(string $message = 'The userlist does not exists', $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
