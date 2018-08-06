<?php

namespace Hedonist\Actions\Place;


class UpdatePlacePresenter
{
    public static function present(UpdatePlaceResponse $placeResponse): array
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