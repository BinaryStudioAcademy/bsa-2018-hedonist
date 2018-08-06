<?php

namespace Hedonist\Actions\Place;


class AddPlacePresenter
{
    public static function present(AddPlaceResponse $placeResponse): array
    {
        return [
            'id'         => $placeResponse->getId(),
            'latitude'   => $placeResponse->getLatitude(),
            'longitude'  => $placeResponse->getLongitude(),
            'zip'        => $placeResponse->getZip(),
            'address'    => $placeResponse->getAddress(),
            'category'   => $placeResponse->getAddress(),
            'city'       => $placeResponse->getCity(),
            'creator'    => $placeResponse->getCreatorEmail(),
            'created_at' => $placeResponse->getCreatedAt(),
            'updated_at' => $placeResponse->getUpdatedAt(),
        ];
    }
}