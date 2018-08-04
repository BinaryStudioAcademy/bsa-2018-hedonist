<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\RequestInterface;

class DeleteSpecialFeatureRequest implements RequestInterface
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