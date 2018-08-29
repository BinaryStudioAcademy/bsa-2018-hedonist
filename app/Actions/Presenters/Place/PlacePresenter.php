<?php

namespace Hedonist\Actions\Presenters\Place;

use Hedonist\Entities\Place\Place;

class PlacePresenter
{
    private $presentation = [];

    public function present(Place $place)
    {
        return array_merge(
            [
            'id' => $place->id,
            'address' => $place->address,
            'created_at' => $place->created_at->toDateTimeString(),
            'dislikes' => $place->dislikes->count(),
            'likes' => $place->likes->count(),
            'rating' => number_format(round($place->ratings->avg('rating'), 1), 1),
            'ratingCount' => $place->ratings->count(),
            'latitude' => $place->latitude,
            'longitude' => $place->longitude,
            'phone' => $place->phone,
            'website' => $place->website,
            'zip' => $place->zip,
            ],
            $this->presentation
        );
    }

    public function withRating(float $rating): self
    {
        $this->presentation['rating'] = number_format($rating, 1);
        return $this;
    }
}