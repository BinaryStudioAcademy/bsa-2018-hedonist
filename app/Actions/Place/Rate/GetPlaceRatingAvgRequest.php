<?php

namespace Hedonist\Actions\Place\Rate;


class GetPlaceRatingAvgRequest
{

    /** @var int */
    protected $placeId;


    /**
     * SetPlaceRatingResponse constructor.
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