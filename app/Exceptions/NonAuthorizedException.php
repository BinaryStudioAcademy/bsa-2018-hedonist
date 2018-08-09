<?php

namespace Hedonist\Exceptions;

use LogicException;

class NonAuthorizedException extends LogicException
{
    public function __construct(string $message = 'Non authorized action', $code = 400)
    {
        $this->message = $message;
        $this->code = $code;
    }
}