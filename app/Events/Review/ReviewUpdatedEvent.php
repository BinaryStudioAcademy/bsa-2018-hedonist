<?php

namespace Hedonist\Events\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Events\Dispatchable;

class ReviewUpdatedEvent
{
    use Dispatchable;

    private $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function getReview(): Review
    {
        return $this->review;
    }
}
