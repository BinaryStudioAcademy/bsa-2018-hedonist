<?php

namespace Hedonist\Exceptions\Auth;

use Hedonist\Exceptions\DomainException;

class InvalidUserDataException extends DomainException
{
   public static function create(): self
   {
       return new self("Sorry, looks like your data is corrupted. Please, contact our customer support");
   }
}