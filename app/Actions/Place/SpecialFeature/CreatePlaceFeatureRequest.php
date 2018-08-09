<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class CreatePlaceFeatureRequest
{
    protected $placeFeatureName;

    public function __construct(string $placeFeatureName)
    {
        $this->placeFeatureName = $placeFeatureName;
    }

    public function getPlaceFeatureName() : string
    {
        return $this->placeFeatureName;
    }
}