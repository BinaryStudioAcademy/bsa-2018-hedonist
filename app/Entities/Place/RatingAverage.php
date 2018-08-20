<?php

namespace Hedonist\Entities\Place;


class RatingAverage
{
    public $placeId;
    public $avgRating;

    public function __construct(int $placeId, float $avgRating)
    {
        $this->placeId = $placeId;
        $this->avgRating = $avgRating;
    }
}