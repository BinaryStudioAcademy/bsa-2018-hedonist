<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

class GetPlaceItemPresenter
{
    public static function present(GetPlaceItemResponse $placeResponse): array
    {
        $localization = null;
        if ($placeResponse->getLocalization()->isNotEmpty()) {
            $localization = array_reduce(
                $placeResponse->getLocalization()->toArray(),
                function ($carry, $localizationItem) {
                    $localizationPresenter = [
                        'id' => $localizationItem['id'],
                        'name' => $localizationItem['place_name'],
                        'description' => $localizationItem['place_description'],
                        'languageId' => $localizationItem['language_id']
                    ];
                    $carry[$localizationItem['language']['code']] = $localizationPresenter;
                    return $carry;
                },
                []
            );
        }

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
            'localization' => $localization,
            'reviews' => $placeResponse->getReviews()->isNotEmpty()
                ? array_map(function ($review) {
                    return [
                        'id' => $review['id'],
                        'userId' => $review['user_id'],
                        'description' => $review['description']
                    ];
                }, $placeResponse->getReviews()->toArray())
                : null,
            'features' => $placeResponse->getFeatures()->isNotEmpty()
                ? array_map(function ($feature) {
                    return [
                        'id' => $feature['id'],
                        'name' => $feature['name'],
                    ];
                }, $placeResponse->getFeatures()->toArray())
                : null,
            'category' => [
                'id' => $placeResponse->getCategory()->id,
                'name' => $placeResponse->getCategory()->name
            ],
            'city' => [
                'id' => $placeResponse->getCity()->id,
                'name' => $placeResponse->getCity()->name
            ],
            'rating' => $placeResponse->getRating(),
        ];
    }
}
