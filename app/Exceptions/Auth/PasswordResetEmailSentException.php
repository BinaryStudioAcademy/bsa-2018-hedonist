<?php

namespace Hedonist\Exceptions\Auth;

use Throwable;

class PasswordResetEmailSentException extends \Exception
{
    public function __construct(string $message = "Unable to send password recovery link", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}