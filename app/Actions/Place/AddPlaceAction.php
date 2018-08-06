<?php

namespace Hedonist\Actions\Place;


use Hedonist\Entities\Place\Place;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class AddPlaceAction
{
    protected $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(AddPlaceRequest $placeRequest): AddPlaceResponse
    {
        $place = $this->placeRepository->save(new Place([
            'creator_id' => $placeRequest->getCreatorId(),
            'category_id' => $placeRequest->getCategoryId(),
            'city_id' => $placeRequest->getCityId(),
            'longitude' => $placeRequest->getLongitude(),
            'latitude' => $placeRequest->getLatitude(),
            'zip' => $placeRequest->getZip(),
            'address' => $placeRequest->getAddress(),
        ]));

        return new AddPlaceResponse(
            $place->id,
            $place->creator->email,    // TODO here should be a userInfo->username loaded from user_info
            $place->category->name,
            $place->city->name,
            $place->longitude,
            $place->latitude,
            $place->zip,
            $place->address,
            $place->created_at,
            $place->updated_at
        );
    }
}
