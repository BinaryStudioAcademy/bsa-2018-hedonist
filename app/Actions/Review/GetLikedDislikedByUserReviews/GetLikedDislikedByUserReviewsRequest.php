<?php

namespace Hedonist\Actions\Review\GetLikedDislikedByUserReviews;

use Illuminate\Support\Collection;

class GetLikedDislikedByUserReviewsRequest
{
    private $reviews;

    public function __construct(Collection $reviews)
    {
        $this->reviews = $reviews;
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }
}