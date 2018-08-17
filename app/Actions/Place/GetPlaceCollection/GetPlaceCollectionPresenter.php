<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\User\User;

class GetPlaceCollectionPresenter
{
    private static function presentAsArray(Place $place, ?int $userId): array
    {
        $placeArray = [];


        $placeArray['category'] = [
            'id' => $place->category->id,
            'name' => $place->category->name
        ];


        foreach ($place->localization as $localization) {
            $placeArray['localization'][] = [
                'language' => $localization->language->code,
                'name' => $localization->place_name,
                'description' => $localization->place_description
            ];
        }

        foreach ($place->category->tags as $tag) {
            $placeArray['category']['tags'][] = [
                'id' => $tag->id,
                'name' => $tag->name
            ];
        }
        foreach ($place->photos as $photo) {
            $placeArray['photos'][] = [
                'id' => $photo->id,
                'description' => $photo->description,
                'img_url' => $photo->img_url,
                'creator_id' => $photo->creator_id
            ];
        }

        return $placeArray;
    }

    private static function presentReview(Review $review, ?int $userId): array
    {
        $result = [
            'id' => $review->getKey(),
            'description' => $review->description,
            'user' => !is_null($review->user->info) ? [
                'first_name' => $review->user->info->first_name,
                'last_name' => $review->user->info->last_name,
                'avatar_url' => $review->user->info->avatar_url,
            ] : null,
            'likes' => $review->likes->count(),
            'dislikes' => $review->dislikes->count(),
            'liked' => $review->isLiked($userId),
            'disliked' => $review->isDisliked($userId)
        ];

        return $result;
    }

    public static function present(GetPlaceCollectionResponse $placeResponse, ?int $userId = null): array
    {
        return $placeResponse->getPlaceCollection()->map(function (Place $place) use ($userId) {
            return self::presentAsArray($place, $userId);
        })
            ->toArray();
    }
}