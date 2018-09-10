<?php

namespace Hedonist\Policies;

use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;

class ReviewPolicy
{
    public function likeOrDislikeReview(User $user, Review $review)
    {
        return $user->id !== $review->user->id;
    }
}