<?php

namespace Hedonist\Actions\Review\Like;

class LikeReviewRequest
{
    private $reviewId;

    public function __construct(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public function getReviewId(): int
    {
        return $this->reviewId;
    }
}