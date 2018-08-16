<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Entities\Place\Place;

class GetPlaceCollectionPresenter
{
    public static function presentAsArray(Place $place): array
    {
        $placeArray = [];

        $placeArray['id'] = $place->id;
        $placeArray['address'] = $place->address;
        $placeArray['city'] = $place->city;
        $placeArray['created_at'] = $place->created_at->toDateTimeString();
        $placeArray['dislikes'] = $place->dislikes->count();
        $placeArray['likes'] = $place->likes->count();
        $placeArray['rating'] = number_format(round($place->ratings->avg('rating'), 1), 1);
        $placeArray['latitude'] = $place->latitude;
        $placeArray['longitude'] = $place->longitude;
        $placeArray['phone'] = $place->phone;
        $placeArray['website'] = $place->website;
        $placeArray['zip'] = $place->zip;
        $placeArray['category'] = [
            'id' => $place->category->id,
            'name' => $place->category->name
        ];
        foreach ($place->localization as $localization) {
            $placeArray['localization'][] = [
                'language' => $localization->language->code,
                'name' => $localization->place_name,
                'description' => $localization->place_description
            ];
        }
        foreach ($place->category->tags as $tag) {
            $placeArray['category']['tags'][] = [
                'id' => $tag->id,
                'name' => $tag->name
            ];
        }

        return $placeArray;
    }

    public static function present(GetPlaceCollectionResponse $placeResponse): array
    {
        $placesArray = [];

        foreach ($placeResponse->getPlaceCollection() as $place) {
            $placesArray[] = self::presentAsArray($place);
        }

        return $placesArray;
    }
}