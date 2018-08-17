<?php

namespace Hedonist\Actions\Presenters\Feature;

use Hedonist\Entities\Place\PlaceFeature;

class FeaturePresenter
{
    public function present(PlaceFeature $feature):array
    {
        return [
            'id' => $feature->id,
            'name' => $feature->name,
        ];
    }
}