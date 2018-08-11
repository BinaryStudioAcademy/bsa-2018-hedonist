<?php

namespace Hedonist\Exceptions\Auth;

use Throwable;

class InvalidUserDataException extends \Exception
{
    public function __construct(
        string $message = "Sorry, looks like your data is corrupted. Please, contact our customer support",
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}