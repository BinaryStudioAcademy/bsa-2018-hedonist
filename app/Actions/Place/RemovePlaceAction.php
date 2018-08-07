<?php

namespace Hedonist\Actions\Place;


use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;
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
        if (!$place = $this->placeRepository->getById($placeRequest->getId())) {
             throw new PlaceDoesNotExistException;
        }

        $this->placeRepository->deleteById($placeRequest->getId());
        return new RemovePlaceResponse();
    }
}
