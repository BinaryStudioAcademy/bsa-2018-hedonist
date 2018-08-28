<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionResponse;
use Hedonist\Entities\Place\Location;
use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByCategoryCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByLocationCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByNameCriteria;
use Hedonist\Repositories\Place\Criterias\LatestReviewForPlaceCriteria;
use Hedonist\Repositories\Place\Criterias\PlacePaginationCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceCollectionByFiltersAction
{
    private $placeRepository;
    private $reviewRepository;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->placeRepository = $placeRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(GetPlaceCollectionByFiltersRequest $request): GetPlaceCollectionResponse
    {
        $categoryId = $request->getCategoryId();
        $name = $request->getName();
        $location = $request->getLocation();
        $page = $request->getPage() ?: GetPlaceCollectionByFiltersRequest::DEFAULT_PAGE;
        $criterias = [];

        if (!is_null($location)) {
            try {
                $location = Location::fromString($location);
            } catch (\InvalidArgumentException $e) {
                throw new PlaceLocationInvalidException($e->getMessage());
            }
            $criterias[] = new GetPlaceByLocationCriteria($location);
        }

        if (!is_null($categoryId)) {
            $criterias[] = new GetPlaceByCategoryCriteria($categoryId);
        }

        if (!is_null($name)) {
            $criterias[] = new GetPlaceByNameCriteria($name);
        }

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlacePaginationCriteria($page),
            new AllPlacePhotosCriteria(),
            new LatestReviewForPlaceCriteria(),
            ...$criterias
        );

        return new GetPlaceCollectionResponse($places, Auth::user());
    }
}