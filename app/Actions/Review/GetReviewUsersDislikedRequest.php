<?php

namespace Hedonist\Actions\Review;

class GetReviewUsersDislikedRequest
{
    private $reviewId;

    public function __construct(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public function getReviewId()
    {
        return $this->reviewId;
    }
}
