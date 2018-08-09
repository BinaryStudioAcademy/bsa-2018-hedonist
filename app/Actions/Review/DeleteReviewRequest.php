<?php

namespace Hedonist\Actions\Review;

class DeleteReviewRequest
{
    private $reviewId;

    public function __construct(int $id)
    {
        $this->reviewId = $id;
    }

    public function getReviewId(): int
    {
        return $this->reviewId;
    }
}
