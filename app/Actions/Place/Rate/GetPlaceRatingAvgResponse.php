<?php

namespace Hedonist\Actions\Place\Rate;


class GetPlaceRatingAvgResponse
{

    /** @var int */
    protected $placeId;

    /** @var float */
    protected $ratingAvgValue;

    /**
     * GetPlaceRatingResponse constructor.
     * @param int $placeId
     * @param float $ratingAvgValue
     */
    public function __construct($placeId, $ratingAvgValue)
    {
        $this->placeId = $placeId;
        $this->ratingAvgValue = $ratingAvgValue;
    }

    /**
     * @return int
     */
    public function getPlaceId(): int
    {
        return $this->placeId;
    }

    /**
     * @return float
     */
    public function getRatingAvgValue(): float
    {
        return $this->ratingAvgValue;
    }

}