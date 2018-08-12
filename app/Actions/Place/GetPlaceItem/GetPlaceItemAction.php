<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class GetPlaceItemAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceItemRequest $getItemRequest): GetPlaceItemResponse
    {
        $place = $this->placeRepository->getById($getItemRequest->getId());
        if (! $place) {
            throw new PlaceDoesNotExistException;
        }

        return new GetPlaceItemResponse($place);
    }
}
