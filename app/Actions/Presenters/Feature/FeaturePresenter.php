<?php

namespace Hedonist\Actions\Presenters\Feature;

use Hedonist\Actions\Presenters\PresentsCollectionTrait;
use Hedonist\Entities\Place\PlaceFeature;

class FeaturePresenter
{
    use PresentsCollectionTrait;

    public function present(PlaceFeature $feature):array
    {
        return [
            'id' => $feature->id,
            'name' => $feature->name,
        ];
    }
}