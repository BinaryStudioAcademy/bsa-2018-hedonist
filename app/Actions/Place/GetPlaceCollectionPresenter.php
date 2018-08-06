<?php

namespace Hedonist\Actions\Place;


class GetPlaceCollectionPresenter
{
    public static function present(GetPlaceCollectionResponse $placeResponse): array
    {
        $placesArray = [];

        foreach ($placeResponse->getPlaceCollection() as $place) {
            $placesArray[] = $place;
        }

        return $placesArray;
    }
}