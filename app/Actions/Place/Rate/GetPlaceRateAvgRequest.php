<?php

namespace Hedonist\Actions\Place\Rate;


class GetPlaceRateAvgRequest
{

    /** @var int */
    protected $placeId;


    /**
     * SetRateResponse constructor.
     * @param int $placeId
     */
    public function __construct($placeId)
    {
        $this->placeId = $placeId;
    }

    /**
     * @return int
     */
    public function getPlaceId(): int
    {
        return $this->placeId;
    }

}