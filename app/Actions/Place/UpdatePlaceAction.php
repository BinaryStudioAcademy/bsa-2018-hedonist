<?php

namespace Hedonist\Actions\Place;


use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class UpdatePlaceAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(UpdatePlaceRequest $placeRequest): UpdatePlaceResponse
    {
        if (!$place = $this->placeRepository->getById($placeRequest->getId())) {
            throw new \Exception('TODO'); // TODO change exception
        }

        $place->creator_id = $placeRequest->getCreatorId();
        $place->category_id = $placeRequest->getCategoryId();
        $place->city_id = $placeRequest->getCityId();
        $place->longitude = $placeRequest->getLongitude();
        $place->latitude = $placeRequest->getLatitude();
        $place->zip = $placeRequest->getZip();
        $place->address = $placeRequest->getAddress();
        $place = $this->placeRepository->save($place);

        return new UpdatePlaceResponse(
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
