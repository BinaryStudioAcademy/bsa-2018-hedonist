<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionResponse;
use Hedonist\Entities\Place\Location;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\LastReviewForPlaceCriteria;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Place\PlaceSearchCriteria;
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
        $location = $request->getLocation();
        $page = $request->getPage() ? : GetPlaceCollectionByFiltersRequest::DEFAULT_PAGE;

        if ($location) {
            try {
                $location = Location::fromString($location);
            } catch (\InvalidArgumentException $e) {
                throw new PlaceLocationInvalidException($e->getMessage());
            }
        }

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlaceSearchCriteria($page, $categoryId, $location),
            new AllPlacePhotosCriteria(),
            new LastReviewForPlaceCriteria()
        );

        return new GetPlaceCollectionResponse($places, Auth::user());
    }
}