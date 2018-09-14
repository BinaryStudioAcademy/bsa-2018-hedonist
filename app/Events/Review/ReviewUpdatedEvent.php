<?php

namespace Hedonist\Events\Review;

use Illuminate\Foundation\Events\Dispatchable;

class ReviewUpdatedEvent
{
    use Dispatchable;

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
