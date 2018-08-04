<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\RequestInterface;

class CreateSpecialFeatureRequest implements RequestInterface
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