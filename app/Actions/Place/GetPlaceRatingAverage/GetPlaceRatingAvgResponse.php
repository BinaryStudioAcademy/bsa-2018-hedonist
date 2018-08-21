<?php

namespace Hedonist\Actions\Place\GetPlaceRatingAverage;

class GetPlaceRatingAvgResponse
{
    private $placeId;

    private $ratingAvgValue;

    private $ratingVotesCount;

    public function __construct(int $placeId, float $ratingAvgValue, int $ratingVotesCount)
    {
        $this->placeId = $placeId;
        $this->ratingAvgValue = $ratingAvgValue;
        $this->ratingVotesCount = $ratingVotesCount;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getRatingAvgValue(): float
    {
        return $this->ratingAvgValue;
    }

    public function getRatingVotesCount(): int
    {
        return $this->ratingVotesCount;
    }
}