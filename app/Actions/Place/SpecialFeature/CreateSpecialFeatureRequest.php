<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class CreateSpecialFeatureRequest
{
    protected $placesSpecialFeatureName;

    /**
     * CreateSpecialFeatureRequest constructor.
     * @param $placesSpecialFeatureName
     */
    public function __construct($placesSpecialFeatureName)
    {
        $this->placesSpecialFeatureName = $placesSpecialFeatureName;
    }

    /**
     * @return mixed
     */
    public function getPlacesSpecialFeatureName()
    {
        return $this->placesSpecialFeatureName;
    }



}