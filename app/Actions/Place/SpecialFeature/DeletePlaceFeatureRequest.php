<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class DeletePlaceFeatureRequest
{
    protected $placePlaceFeatureId;

    /**
     * DeletePlaceFeatureRequest constructor.
     * @param int $placePlaceFeatureId
     */
    public function __construct(int $placePlaceFeatureId)
    {
        $this->placePlaceFeatureId = $placePlaceFeatureId;
    }

    /**
     * @return mixed
     */
    public function getPlaceFeatureId() : int
    {
        return $this->placePlaceFeatureId;
    }

}