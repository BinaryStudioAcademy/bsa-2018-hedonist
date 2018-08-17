<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

class GetPlaceItemPresenter
{
    public static function present(GetPlaceItemResponse $placeResponse, ?int $userId = null): array
    {
        return [
            'id' => $placeResponse->getId(),
            'latitude' => $placeResponse->getLatitude(),
            'longitude' => $placeResponse->getLongitude(),
            'zip' => $placeResponse->getZip(),
            'address' => $placeResponse->getAddress(),
            'phone' => $placeResponse->getPhone(),
            'website' => $placeResponse->getWebsite(),
            'creatorId' => $placeResponse->getCreatorId(),
            'createdAt' => $placeResponse->getCreatedAt(),
            'updatedAt' => $placeResponse->getUpdatedAt(),
            'city' => [
                'id' => $placeResponse->getCity()->id,
                'name' => $placeResponse->getCity()->name
            ],
            'rating' => $placeResponse->getRating(),
        ];
    }
}
