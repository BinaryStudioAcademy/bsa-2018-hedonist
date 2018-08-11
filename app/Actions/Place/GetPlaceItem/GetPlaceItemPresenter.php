<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

class GetPlaceItemPresenter
{
    public static function present(GetPlaceItemResponse $placeResponse): array
    {
        return [
            'id'           => $placeResponse->getId(),
            'latitude'     => $placeResponse->getLatitude(),
            'longitude'    => $placeResponse->getLongitude(),
            'zip'          => $placeResponse->getZip(),
            'address'      => $placeResponse->getAddress(),
            'phone'        => $placeResponse->getPhone(),
            'website'      => $placeResponse->getWebsite(),
            'creatorId'    => $placeResponse->getCreatorId(),
            'createdAt'    => $placeResponse->getCreatedAt(),
            'updatedAt'    => $placeResponse->getUpdatedAt(),
            'localization' => $placeResponse->getLocalization()->isNotEmpty() ? [
                // have to access first localization because we don't know which lang to use
                'name'        => $placeResponse->getLocalization()[0]->place_name,
                'description' => $placeResponse->getLocalization()[0]->place_description,
                'placeId'     => $placeResponse->getLocalization()[0]->place_id,
                'languageId'  => $placeResponse->getLocalization()[0]->language_id
            ] : null,
            'category' => [
                'id'   => $placeResponse->getCategory()->id,
                'name' => $placeResponse->getCategory()->name
            ],
            'city' => [
                'id'   => $placeResponse->getCity()->id,
                'name' => $placeResponse->getCity()->name
            ],
            'rating' => $placeResponse->getRating(),
        ];
    }
}
