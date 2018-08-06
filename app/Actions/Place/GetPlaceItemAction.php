<?php

namespace Hedonist\Actions\Place;


use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class GetPlaceItemAction
{
    protected $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceItemRequest $getItemRequest): GetPlaceItemResponse
    {
        if (!$place = $this->placeRepository->getById($getItemRequest->getId())) {
            throw new PlaceDoesNotExistException;
        }

        return new GetPlaceItemResponse(
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
