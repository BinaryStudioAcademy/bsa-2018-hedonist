<?php

namespace Hedonist\Actions\Place\GetRecommendationPlaceCollection;

use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionResponse;
use Hedonist\Entities\Place\Location;
use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByCategoryCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByLocationCriteria;
use Hedonist\Repositories\Place\Criterias\LatestReviewForPlaceCriteria;
use Hedonist\Repositories\Place\Criterias\PlaceCustomLimitCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetRecommendationPlaceCollectionAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetRecommendationPlaceCollectionRequest $request): GetPlaceCollectionResponse
    {
        $currentPlace = $this->placeRepository->getById($request->getId());
        if (!$currentPlace) {
            throw new PlaceDoesNotExistException();
        }
        $criterias = [];

        try {
            $coords = $currentPlace->longitude . ',' . $currentPlace->latitude;
            $location = Location::fromString($coords);
        } catch (\InvalidArgumentException $e) {
            throw new PlaceLocationInvalidException($e->getMessage());
        }
        $criterias[] = new GetPlaceByLocationCriteria($location);
        $criterias[] = new GetPlaceByCategoryCriteria($currentPlace->category_id);

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlaceCustomLimitCriteria(3),
            new AllPlacePhotosCriteria(),
            new LatestReviewForPlaceCriteria(),
            ...$criterias
        );

        return new GetPlaceCollectionResponse($places, Auth::user());
    }
}