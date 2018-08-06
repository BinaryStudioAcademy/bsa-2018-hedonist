<?php

namespace Hedonist\Exceptions\Auth;

use Throwable;

class EmailAlreadyExistsException extends \LogicException
{
    public function __construct(string $message = "Sorry, this email is already in use", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}