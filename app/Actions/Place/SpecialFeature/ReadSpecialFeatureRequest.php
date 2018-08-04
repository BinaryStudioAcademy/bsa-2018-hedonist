<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class ReadSpecialFeatureRequest
{
    protected $placeSpecialFeatureId;

    /**
     * DeleteSpecialFeatureRequest constructor.
     * @param $placeSpecialFeatureId
     */
    public function __construct($placeSpecialFeatureId)
    {
        $this->placeSpecialFeatureId = $placeSpecialFeatureId;
    }

    /**
     * @return mixed
     */
    public function getPlaceSpecialFeatureId()
    {
        return $this->placeSpecialFeatureId;
    }
}