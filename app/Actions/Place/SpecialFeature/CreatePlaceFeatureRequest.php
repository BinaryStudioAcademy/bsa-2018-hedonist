<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class CreatePlaceFeatureRequest
{
    protected $placeFeatureName;

    /**
     * CreatePlaceFeatureRequest constructor.
     * @param string $placeFeatureName
     */
    public function __construct(string $placeFeatureName)
    {
        $this->placeFeatureName = $placeFeatureName;
    }

    /**
     * @return string
     */
    public function getPlaceFeatureName() : string
    {
        return $this->placeFeatureName;
    }



}