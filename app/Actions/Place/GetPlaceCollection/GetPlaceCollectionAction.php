<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Review\Criterias\GetLastReviewByPlaceIdsCriteria;
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
        $limit = $request->getLimit() ?: 20;
        $offset = $request->getPage() ? ($request->getPage() - 1) * $limit : 0;
        $places = $this->placeRepository->getAllWithRelations($offset, $limit);
        $reviews = $this->reviewRepository->findByCriteria(
            new GetLastReviewByPlaceIdsCriteria($places->pluck('id')->toArray())
        );

        return new GetPlaceCollectionResponse($places, $reviews, Auth::user());
    }
}
