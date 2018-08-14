<?php

namespace Hedonist\Exceptions\Auth;

use Hedonist\Exceptions\DomainException;

class PasswordsDosentMatchException extends DomainException
{
    public function __construct(string $message = "Provided password is incorrect", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}