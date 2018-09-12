<?php

namespace Hedonist\Exceptions\Auth;

use Hedonist\Exceptions\DomainException;

class InvalidLanguageException extends DomainException
{
    public static function create(): self
    {
        return new self('Wrong language');
    }
}
