<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

class GetPlaceItemPresenter
{
    public static function present(GetPlaceItemResponse $placeResponse,?int $userId = null): array
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
                ? $placeResponse->getLocalization()->map(function ($localization){
                    return [
                        'id'          => $localization['id'],
                        'name'        => $localization['place_name'],
                        'description' => $localization['place_description'],
                        'languageId'  => $localization['language_id']
                    ];
                })->toArray()
                : null,
            'reviews' => $placeResponse->getReviews()->isNotEmpty()
                ?  $placeResponse->getReviews()->map(function($review) use ($userId){
                    return [
                        'id'          => $review['id'],
                        'user'      => $review['user']['info'] ?? null,
                        'description' => $review['description'],
                        'likes' => $review->likes->count(),
                        'dislikes' => $review->dislikes->count(),
                        'liked' => $review->isLiked($userId),
                        'disliked' => $review->isDisliked($userId)
                    ];
                })->toArray()
                : null,
            'features' => $placeResponse->getFeatures()->isNotEmpty()
                ? $placeResponse->getFeatures()->map(function ($feature) {
                    return [
                        'id'   => $feature['id'],
                        'name' => $feature['name'],
                    ];
                })->toArray()
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
