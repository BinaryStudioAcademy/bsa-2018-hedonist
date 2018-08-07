<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class GetPlaceCollectionAction
{
    protected $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceCollectionRequest $request): GetPlaceCollectionResponse
    {
        $places = $this->placeRepository->findAll();

        return new GetPlaceCollectionResponse($places);
    }
}
