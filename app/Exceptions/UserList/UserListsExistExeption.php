<?php
namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;

class UserListsExistExeption extends DomainException
{
    public function __construct(string $message = 'Users Lists are empty', $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}