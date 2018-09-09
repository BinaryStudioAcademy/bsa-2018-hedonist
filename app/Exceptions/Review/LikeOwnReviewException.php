<?php

namespace Hedonist\Exceptions\Review;

use Hedonist\Exceptions\DomainException;

class LikeOwnReviewException extends DomainException
{
   public static function create()
   {
       return new self('You can\'t like or dislike your own review :(');
   }
}