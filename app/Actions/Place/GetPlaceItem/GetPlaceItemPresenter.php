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
            'localization' => $placeResponse->getLocalization()->isNotEmpty()
                ? array_map(function ($localization) {
                    return [
                        'id'          => $localization['id'],
                        'name'        => $localization['place_name'],
                        'description' => $localization['place_description'],
                        'languageId'  => $localization['language_id']
                    ];
                }, $placeResponse->getLocalization()->toArray())
                : null,
            'reviews' => $placeResponse->getReviews()->isNotEmpty()
                ? array_map(function ($review) {
                    return [
                        'id'          => $review['id'],
                        'userId'      => $review['user_id'],
                        'description' => $review['description']
                    ];
                }, $placeResponse->getReviews()->toArray())
                : null,
            'features' => $placeResponse->getFeatures()->isNotEmpty()
                ? array_map(function ($feature) {
                    return [
                        'id'   => $feature['id'],
                        'name' => $feature['name'],
                    ];
                }, $placeResponse->getFeatures()->toArray())
                : null,
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
