<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Entities\Place\Checkin;

class GetUserCheckInCollectionPresenter
{
    public static function present(GetUserCheckInCollectionResponse $checkInCollectionResponse): array
    {
        $checkInsArray = [];

        foreach ($checkInCollectionResponse->getPlaceCollection() as $checkIn) {
            $checkInsArray[] = self::presentCollectionItem($checkIn);
        }

        return $checkInsArray;
    }

    public static function presentCollectionItem(Checkin $checkIn)
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
                'rating'    => number_format($checkIn->place->avgRating, 1)
            ]
        ];
    }
}