<?php

namespace Hedonist\Actions\Place\GetPlaceRatingAverage;

class GetPlaceRatingAvgRequest
{
    protected $placeId;

    public function __construct($placeId)
    {
        $this->placeId = $placeId;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }
}