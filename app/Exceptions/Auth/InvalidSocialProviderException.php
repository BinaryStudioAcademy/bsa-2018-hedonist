<?php

namespace Hedonist\Exceptions\Auth;

use Hedonist\Exceptions\DomainException;
use Throwable;

class InvalidSocialProviderException extends DomainException
{
    public static function create():self
    {
        return new self("Unknown social provider");
    }
}