<?php

namespace Hedonist\Actions\Review;

use Illuminate\Database\Eloquent\Collection;

class GetReviewCollectionResponse
{
    private $reviewCollection;

    public function __construct(Collection $reviews)
    {
        $this->reviewCollection = $reviews;
    }

    public function getReviewCollection(): array
    {
        return $this->reviewCollection->toArray();
    }
}
