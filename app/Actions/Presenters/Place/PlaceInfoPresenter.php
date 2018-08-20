<?php

namespace Hedonist\Actions\Presenters\Place;

use Hedonist\Entities\Place\PlaceInfo;

class PlaceInfoPresenter
{
    public function present(?PlaceInfo $placeInfo): array
    {
        if (! $placeInfo) return [];
        return [
            'id' => $placeInfo->id,
            'work_weekend' => $placeInfo->work_weekend,
            'facebook' => $placeInfo->facebook,
            'instagram' => $placeInfo->instagram,
            'twitter' => $placeInfo->twitter
        ];
    }
}