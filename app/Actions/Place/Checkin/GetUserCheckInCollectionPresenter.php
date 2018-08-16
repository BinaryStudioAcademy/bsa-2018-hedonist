<?php

namespace Hedonist\Actions\Place\Checkin;

class GetUserCheckInCollectionPresenter
{
    public static function present(GetUserCheckInCollectionResponse $checkInCollectionResponse): array
    {
        return $checkInCollectionResponse->getPlaceCollection()->map(function($checkIn) {
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
                    'placeName' => $checkIn->place->localization[0]->place_name,
                    'rating'    => $checkIn->place->avgRating()
                ]
            ];
        })->toArray();
    }
}