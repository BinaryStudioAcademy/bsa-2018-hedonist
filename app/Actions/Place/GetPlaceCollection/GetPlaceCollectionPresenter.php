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

        $placeArray['id'] = $place->id;
        $placeArray['address'] = $place->address;
        $placeArray['city'] = $place->city;
        $placeArray['created_at'] = $place->created_at->toDateTimeString();
        $placeArray['dislikes'] = $place->dislikes->count();
        $placeArray['likes'] = $place->likes->count();
        $placeArray['rating'] = round($place->ratings->avg('rating'), 1) ?? 0.0;
        $placeArray['latitude'] = $place->latitude;
        $placeArray['longitude'] = $place->longitude;
        $placeArray['phone'] = $place->phone;
        $placeArray['website'] = $place->website;
        $placeArray['zip'] = $place->zip;
        $placeArray['category'] = [
            'id' => $place->category->id,
            'name' => $place->category->name
        ];

        $placeArray['review'] = !is_null($place->reviews->first()) ?
            self::presentReview($place->reviews->first(), $userId) :
            null;

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