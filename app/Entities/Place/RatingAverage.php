<?php

namespace Hedonist\Entities\Place;

class RatingAverage
{
    private $placeId;
    private $avgRating;

    public function __construct(int $placeId, float $avgRating)
    {
        $this->placeId = $placeId;
        $this->avgRating = $avgRating;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getAvgRating(): float
    {
        return $this->avgRating;
    }
}