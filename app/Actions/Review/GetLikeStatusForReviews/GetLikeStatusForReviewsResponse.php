<?php

namespace Hedonist\Actions\Review\GetLikeStatusForReviews;

use Illuminate\Support\Collection;

class GetLikeStatusForReviewsResponse
{
    private $reviewCollection;

    public function __construct(Collection $reviewCollection)
    {
        $this->reviewCollection = $reviewCollection;
    }

    public function getReviewCollection(): Collection
    {
        return $this->reviewCollection;
    }
}