<?php

namespace Hedonist\Actions\Presenters\Place;

use Hedonist\Entities\Place\Place;

class PlacePresenter
{
    public function present(Place $place)
    {
        return [
            'id' => $place->id,
            'address' => $place->address,
            'city' => $place->city,
            'created_at' => $place->created_at->toDateTimeString(),
            'dislikes' => $place->dislikes->count(),
            'likes' => $place->likes->count(),
            'rating' => number_format(round($place->ratings->avg('rating'), 1), 1),
            'ratingCount' => $place->ratings->count('rating'),
            'latitude' => $place->latitude,
            'longitude' => $place->longitude,
            'phone' => $place->phone,
            'website' => $place->website,
            'zip' => $place->zip,
        ];
    }
}