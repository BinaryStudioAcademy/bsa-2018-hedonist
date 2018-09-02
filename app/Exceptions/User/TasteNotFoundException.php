<?php

namespace Hedonist\Exceptions\User;

use Hedonist\Exceptions\DomainException;

class TasteNotFoundException extends DomainException
{
    protected $message = 'Taste not found!';
}