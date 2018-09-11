<?php

namespace Hedonist\Actions\Review;

use Illuminate\Database\Eloquent\Collection;

class GetReviewCollectionWithPlaceByUserResponse
{
    private $reviews;

    public function __construct(Collection $reviews)
    {
        $this->reviews = $reviews;
    }

    public function getCollection(): Collection
    {
        return $this->reviews;
    }
}