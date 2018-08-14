<?php

namespace Hedonist\Actions\Place\RemovePlace;

use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class RemovePlaceAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(RemovePlaceRequest $placeRequest): RemovePlaceResponse
    {
        $place = $this->placeRepository->getById($placeRequest->getId());
        if (!$place) {
            throw new PlaceDoesNotExistException;
        }

        $this->placeRepository->deleteById($placeRequest->getId());
        return new RemovePlaceResponse();
    }
}
