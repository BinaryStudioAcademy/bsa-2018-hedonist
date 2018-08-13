<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

class GetPlaceCollectionPresenter
{
    public static function present(GetPlaceCollectionResponse $placeResponse): array
    {
        $placesArray = [];

        foreach ($placeResponse->getPlaceCollection() as $key => $place) {
            $placesArray[$key] = $place->toArray();
            $placesArray[$key]['likes'] = $place->likes->count();
            $placesArray[$key]['dislikes'] = $place->dislikes->count();
        }

        return $placesArray;
    }
}