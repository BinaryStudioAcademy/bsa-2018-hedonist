<?php

namespace Hedonist\Exceptions\Auth;

use Throwable;

class PasswordResetFailedException extends \LogicException
{
    public function __construct(string $message = "Failed to reset user password", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}