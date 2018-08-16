<?php
namespace Hedonist\Exceptions\UserList;

use Hedonist\Exceptions\DomainException;

class UserListsExistExeption extends DomainException
{
    public function __construct(string $message = 'Users Lists does not exists', $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}