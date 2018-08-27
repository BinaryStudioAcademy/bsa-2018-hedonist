<?php

namespace Hedonist\Actions\Place\GetPlaceCollection;

use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Review\Criterias\GetLastReviewByPlaceIdsCriteria;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceCollectionAction
{
    private $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetPlaceCollectionRequest $request): GetPlaceCollectionResponse
    {
        $places = $this->placeRepository->getAllWithRelations();

        return new GetPlaceCollectionResponse($places, Auth::user());
    }
}
