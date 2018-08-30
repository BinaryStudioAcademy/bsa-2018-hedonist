<?php

namespace Hedonist\Actions\Place\GetPlaceCollectionByFilters;

use Hedonist\Actions\Place\GetPlaceCollection\GetPlaceCollectionResponse;
use Hedonist\Entities\Place\Location;
use Hedonist\Entities\User\User;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Repositories\Place\Criterias\AllPlacePhotosCriteria;
use Hedonist\Repositories\Place\Criterias\CheckinCriteria;
use Hedonist\Repositories\Place\Criterias\SavedCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByCategoryCriteria;
use Hedonist\Repositories\Place\Criterias\GetPlaceByLocationCriteria;
use Hedonist\Repositories\Place\Criterias\LatestReviewForPlaceCriteria;
use Hedonist\Repositories\Place\Criterias\PlacePaginationCriteria;
use Hedonist\Repositories\Place\Criterias\TopRatedCriteria;
use Hedonist\Repositories\Place\Criterias\TopReviewedCriteria;
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
        $location = $request->getLocation();
        $page = $request->getPage() ?: GetPlaceCollectionByFiltersRequest::DEFAULT_PAGE;
        $criterias = [];


        /** @var User $user */
        $user = Auth::user();

        if (!is_null($location)) {
            try {
                $criterias[] = new GetPlaceByLocationCriteria(Location::fromString($location));
            } catch (\InvalidArgumentException $e) {
                throw new PlaceLocationInvalidException($e->getMessage());
            }
        }
        if (!is_null($categoryId)) {
            $criterias[] = new GetPlaceByCategoryCriteria($categoryId);
        }

        if ($request->isTopReviewed()) {
            $criterias[] = new TopReviewedCriteria;
        }

        if ($request->isTopRated()) {
            $criterias[] = new TopRatedCriteria;
        }

        if ($request->isCheckin()) {
            $criterias[] = new CheckinCriteria($user);
        }

        if ($request->isSaved()) {
            $criterias[] = new SavedCriteria($user);
        }

        $places = $this->placeRepository->findCollectionByCriterias(
            new PlacePaginationCriteria($page),
            new AllPlacePhotosCriteria(),
            new LatestReviewForPlaceCriteria(),
            ...$criterias
        );

        return new GetPlaceCollectionResponse($places, $user);
    }
}