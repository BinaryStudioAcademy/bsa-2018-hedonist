<?php

namespace Hedonist\Actions\Place\SetPlaceRating;

class SetPlaceRatingRequest
{
    protected $placeId;

    protected $ratingValue;

    public function __construct(int $ratingValue, int $placeId)
    {
        $this->placeId = $placeId;
        $this->ratingValue = $ratingValue;
    }

    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    public function getRatingValue(): int
    {
        return $this->ratingValue;
    }
}