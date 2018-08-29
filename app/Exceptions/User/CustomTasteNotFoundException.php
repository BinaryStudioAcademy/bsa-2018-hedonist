<?php

namespace Hedonist\Exceptions\User;

use Hedonist\Exceptions\DomainException;

class CustomTasteNotFoundException extends DomainException
{
    protected $message = 'Custom taste not found!';
}
