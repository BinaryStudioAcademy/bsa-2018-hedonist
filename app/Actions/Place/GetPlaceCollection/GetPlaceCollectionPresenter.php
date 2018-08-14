<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

class GetPlaceCollectionPresenter
{
    public static function present(GetPlaceCollectionResponse $placeResponse): array
    {
        $placesArray = [];

        foreach ($placeResponse->getPlaceCollection() as $key => $place) {
            $placesArray[$key]['id'] = $place->id;
            $placesArray[$key]['address'] = $place->address;
            $placesArray[$key]['category'] = $place->category;
            $placesArray[$key]['city'] = $place->city;
            $placesArray[$key]['created_at'] = $place->created_at->toDateTimeString();
            $placesArray[$key]['dislikes'] = $place->dislikes->count();
            $placesArray[$key]['likes'] = $place->likes->count();
            $placesArray[$key]['rating'] = $place->ratings->avg('rating');
            $placesArray[$key]['latitude'] = $place->latitude;
            $placesArray[$key]['longitude'] = $place->longitude;
            $placesArray[$key]['phone'] = $place->phone;
            $placesArray[$key]['website'] = $place->website;
            $placesArray[$key]['zip'] = $place->zip;
            foreach ($place->localization as $localization) {
                $locale['language'] = $localization->language->code;
                $locale['name'] = $localization->place_name;
                $locale['description'] = $localization->place_description;
                $placesArray[$key]['localization'][] = $locale;
            }
            foreach ($place->tags as $tag) {
                $placesArray[$key]['category']['tags'][] = [
                    'id' => $tag->id,
                    'name' => $tag->name
                ];
            }
        }

        return $placesArray;
    }
}