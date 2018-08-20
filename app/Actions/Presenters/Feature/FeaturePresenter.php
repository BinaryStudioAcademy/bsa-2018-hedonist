<?php

namespace Hedonist\Actions\Presenters\Feature;

use Hedonist\Actions\Presenters\PresentsCollection;
use Hedonist\Entities\Place\PlaceFeature;

class FeaturePresenter
{
    use PresentsCollection;

    public function present(PlaceFeature $feature):array
    {
        return [
            'id' => $feature->id,
            'name' => $feature->name,
        ];
    }
}