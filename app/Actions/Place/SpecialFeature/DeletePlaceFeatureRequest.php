<?php

namespace Hedonist\Actions\Place\SpecialFeature;

class DeletePlaceFeatureRequest
{
    protected $placePlaceFeatureId;

    public function __construct(int $placePlaceFeatureId)
    {
        $this->placePlaceFeatureId = $placePlaceFeatureId;
    }

    public function getPlaceFeatureId() : int
    {
        return $this->placePlaceFeatureId;
    }
}