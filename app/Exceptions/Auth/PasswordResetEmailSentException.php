<?php

namespace Hedonist\Exceptions\Auth;

use Hedonist\Exceptions\DomainException;
use Throwable;

class PasswordResetEmailSentException extends DomainException
{
    public function __construct(string $message = "Unable to send password recovery link", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}