<?php

namespace Hedonist\Actions\Review\Dislike;

class DislikeReviewRequest
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