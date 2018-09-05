<?php

namespace Hedonist\Exceptions\User;

use Hedonist\Exceptions\DomainException;

class FollowYourselfException extends DomainException
{
    public static function create()
    {
        return new self('You can\'t follow yourself');
    }
}