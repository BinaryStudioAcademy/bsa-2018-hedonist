<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Entities\Place\Checkin;
use Hedonist\Entities\Place\RatingAverage;

class GetUserCheckInCollectionPresenter
{
    public static function present(GetUserCheckInCollectionResponse $checkInCollectionResponse): array
    {
        $checkInsArray = [];

        foreach ($checkInCollectionResponse->getPlaceCollection() as $checkIn) {
            $filteredRating = $checkInCollectionResponse
                ->getRatingCollection()
                ->first(function ($rating) use ($checkIn) {
                    /* @var $rating RatingAverage */
                    return $rating->getPlaceId() === $checkIn->place->id;
                });

            $rating = $filteredRating ? $filteredRating->getAvgRating() : 0;
            $checkInsArray[] = self::presentCollectionItem($checkIn, $rating);
        }

        return $checkInsArray;
    }

    public static function presentCollectionItem(Checkin $checkIn, float $rating)
    {
        return [
            'id'        => $checkIn->id,
            'createdAt' => $checkIn->created_at->toDateTimeString(),
            'place'     => [
                'id'        => $checkIn->place->id,
                'latitude'  => $checkIn->place->latitude,
                'longitude' => $checkIn->place->longitude,
                'zip'       => $checkIn->place->zip,
                'address'   => $checkIn->place->address,
                'city'      => $checkIn->place->city->name,
                'category'  => $checkIn->place->category->name,
                'createdAt' => $checkIn->place->created_at->toDateTimeString(),
                'name'      => $checkIn->place->localization[0]->place_name,
                'photo'     => $checkIn->place->photos[0]->img_url,
                'rating'    => number_format($rating, 1)
            ]
        ];
    }
}