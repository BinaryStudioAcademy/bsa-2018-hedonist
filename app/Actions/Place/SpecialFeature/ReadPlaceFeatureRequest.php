<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class ReadPlaceFeatureRequest
{
    protected $placeSpecialFeatureId;

    /**
     * DeletePlaceFeatureRequest constructor.
     * @param $placeSpecialFeatureId
     */
    public function __construct($placeSpecialFeatureId)
    {
        $this->placeSpecialFeatureId = $placeSpecialFeatureId;
    }

    /**
     * @return int
     */
    public function getPlaceFeatureId() : int
    {
        return $this->placeSpecialFeatureId;
    }
}