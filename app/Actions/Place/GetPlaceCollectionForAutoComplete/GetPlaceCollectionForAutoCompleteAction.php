<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete;

use Hedonist\Entities\Place\Location;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByLocationCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByNameCriteria;
use Hedonist\Repositories\Place\Criterias\PlaceCustomLimitCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class GetPlaceCollectionForAutoCompleteAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceCollectionForAutoCompleteRequest $request): GetPlaceCollectionForAutoCompleteResponse
    {
        $name = $request->getName();
        $location = $request->getLocation();
        $criterias = [];

        if (!is_null($location)) {
            try {
                $location = Location::fromString($location, 30);
            } catch (\InvalidArgumentException $e) {
                throw new PlaceLocationInvalidException($e->getMessage());
            }
            $criterias[] = new GetPlaceByLocationCriteria($location);
        }

        if (!is_null($name)) {
            $criterias[] = new GetPlaceByNameCriteria($name);
        }

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlaceCustomLimitCriteria(10),
            new AllPlacePhotosCriteria(),
            ...$criterias
        );

        return new GetPlaceCollectionForAutoCompleteResponse($places);
    }
}