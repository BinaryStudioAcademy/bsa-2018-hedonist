<?php

namespace Hedonist\Exceptions\Auth;

use Hedonist\Exceptions\DomainException;
use Throwable;

class PasswordResetFailedException extends DomainException
{
    public function __construct(string $message = "Failed to reset user password", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}