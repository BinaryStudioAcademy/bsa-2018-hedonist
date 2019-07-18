<?php

namespace Hedonist\Exceptions;

class NonAuthorizedException extends DomainException
{
    public function __construct(string $message = 'Non authorized action', $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
