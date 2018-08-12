<?php

namespace Hedonist\Actions\Review;

class GetReviewPhotoByReviewRequest
{
    private $review_id;

    public function __construct(int $review_id)
    {
        $this->review_id = $review_id;
    }

    public function getReviewId()
    {
        return $this->review_id;
    }
}