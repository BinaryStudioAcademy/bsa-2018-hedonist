<?php

namespace Hedonist\Actions\Place\AddPlace;

class AddPlacePresenter
{
    public static function present(AddPlaceResponse $placeResponse): array
    {
        return [
            'id' => $placeResponse->getId(),
            'latitude' => $placeResponse->getLatitude(),
            'longitude' => $placeResponse->getLongitude(),
            'zip' => $placeResponse->getZip(),
            'address' => $placeResponse->getAddress(),
            'phone' => $placeResponse->getPhone(),
            'website' => $placeResponse->getWebsite(),
            'category_id' => $placeResponse->getCategoryId(),
            'city_id' => $placeResponse->getCityId(),
            'creator_id' => $placeResponse->getCreatorId(),
            'created_at' => $placeResponse->getCreatedAt(),
            'updated_at' => $placeResponse->getUpdatedAt(),
        ];
    }
}