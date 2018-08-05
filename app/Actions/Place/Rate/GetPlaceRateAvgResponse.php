<?php

namespace Hedonist\Actions\Place\Rate;


class GetPlaceRateAvgResponse
{

    /** @var int */
    protected $placeId;

    /** @var float */
    protected $rateAvgValue;

    /**
     * GetRateResponse constructor.
     * @param int $placeId
     * @param float $rateAvgValue
     */
    public function __construct($placeId, $rateAvgValue)
    {
        $this->placeId = $placeId;
        $this->rateAvgValue = $rateAvgValue;
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
    public function getRateAvgValue(): float
    {
        return $this->rateAvgValue;
    }

}