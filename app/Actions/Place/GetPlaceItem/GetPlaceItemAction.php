<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceItemAction
{
    private $placeRepository;
    private $placeCategoryRepository;
    private $cityRepository;
    private $placeRatingRepository;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        PlaceCategoryRepositoryInterface $placeCategoryRepository,
        CityRepositoryInterface $cityRepository,
        PlaceRatingRepositoryInterface $placeRatingRepository
    ) {
        $this->placeRepository = $placeRepository;
        $this->placeCategoryRepository = $placeCategoryRepository;
        $this->cityRepository = $cityRepository;
        $this->placeRatingRepository = $placeRatingRepository;
    }

    public function execute(GetPlaceItemRequest $getItemRequest): GetPlaceItemResponse
    {
        $place = $this->placeRepository->getByIdWithRelations($getItemRequest->getId());
        if (!$place) {
            throw new PlaceDoesNotExistException;
        }
        $checkinsCount = $this->placeRepository->getPlaceCheckinsCountByUser($place->id, Auth::user()->id);

        return new GetPlaceItemResponse($place, Auth::user(), $checkinsCount);
    }
}
