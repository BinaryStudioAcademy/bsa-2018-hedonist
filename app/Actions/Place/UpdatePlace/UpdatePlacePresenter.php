<?php

namespace Hedonist\Actions\Place\UpdatePlace;

class UpdatePlacePresenter
{
    public static function present(UpdatePlaceResponse $placeResponse): array
    {
        return [
            'id'          => $placeResponse->getId(),
            'latitude'    => $placeResponse->getLatitude(),
            'longitude'   => $placeResponse->getLongitude(),
            'zip'         => $placeResponse->getZip(),
            'address'     => $placeResponse->getAddress(),
            'category_id' => $placeResponse->getCategoryId(),
            'city_id'     => $placeResponse->getCityId(),
            'creator_id'  => $placeResponse->getCreatorId(),
            'created_at'  => $placeResponse->getCreatedAt(),
            'updated_at'  => $placeResponse->getUpdatedAt(),
        ];
    }
}