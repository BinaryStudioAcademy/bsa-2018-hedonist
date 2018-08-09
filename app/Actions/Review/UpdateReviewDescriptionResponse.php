<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\Review;

class UpdateReviewDescriptionResponse
{
    private $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function getModel(): Review
    {
        return $this->review;
    }
}
