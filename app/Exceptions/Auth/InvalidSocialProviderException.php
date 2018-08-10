<?php

namespace Hedonist\Exceptions\Auth;

use Throwable;

class InvalidSocialProviderException extends \Exception
{
    public function __construct(string $message = "Unknown social provider", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}