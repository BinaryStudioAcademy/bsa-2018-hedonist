<?php

namespace Hedonist\Actions\Place\Rate;

class GetPlaceRatingAvgResponse
{
    protected $placeId;

    protected $ratingAvgValue;

    public function __construct(int $placeId, float $ratingAvgValue)
    {
        $this->placeId = $placeId;
        $this->ratingAvgValue = $ratingAvgValue;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getRatingAvgValue(): float
    {
        return $this->ratingAvgValue;
    }
}