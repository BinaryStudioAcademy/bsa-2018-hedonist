<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionForAutoComplete;

use Hedonist\Entities\Place\Polygon;
use Hedonist\Exceptions\Place\PlacePolygonInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByNameCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByPolygonCriteria;
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
        $polygon = $request->getPolygon();
        $criterias = [];

        if (!is_null($polygon)) {
            try {
                $polygon = Polygon::fromString($polygon);
            } catch (\InvalidArgumentException $e) {
                throw PlacePolygonInvalidException::createFromMessage($e->getMessage());
            }
            $criterias[] = new GetPlaceByPolygonCriteria($polygon);
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