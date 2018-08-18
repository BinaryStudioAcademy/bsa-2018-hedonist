<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Review\Criterias\GetLastReviewByPlacesIdsCriteria;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceCollectionAction
{
    private $placeRepository;
    private $reviewRepository;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        ReviewRepositoryInterface $reviewRepository)
    {
        $this->placeRepository = $placeRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(GetPlaceCollectionRequest $request): GetPlaceCollectionResponse
    {
        $places = $this->placeRepository->getAllWithRelations();
        $reviews = $this->reviewRepository->findByCriteria(
            new GetLastReviewByPlacesIdsCriteria($places->pluck('id')->toArray())
        );

        return new GetPlaceCollectionResponse($places, $reviews, Auth::user());
    }
}
