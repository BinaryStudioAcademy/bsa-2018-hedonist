<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class ReadPlaceFeatureRequest
{
    protected $placeSpecialFeatureId;

    public function __construct($placeSpecialFeatureId)
    {
        $this->placeSpecialFeatureId = $placeSpecialFeatureId;
    }

    public function getPlaceFeatureId() : int
    {
        return $this->placeSpecialFeatureId;
    }
}