<?php

namespace Hedonist\Actions\Review;

class GetReviewPhotoByPlaceRequest
{
    private $placeId;

    public function __construct(int $placeId)
    {
        $this->placeId = $placeId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }
}