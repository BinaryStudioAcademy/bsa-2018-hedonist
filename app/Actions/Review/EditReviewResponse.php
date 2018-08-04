<?php

namespace Hedonist\Actions\Review;

//use Hedonist\Entities\Review;

class EditReviewResponse
{
    private $review;

    /* Review model does NOT created at the moment */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function getModel(): array
    {
        return [$this->review];
    }
}
