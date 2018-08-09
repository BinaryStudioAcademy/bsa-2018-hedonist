<?php

namespace Hedonist\Exceptions\Auth;


use Throwable;

class PasswordsDosentMatchException extends \Exception
{
    public function __construct(string $message = "Provided password is incorrect", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}