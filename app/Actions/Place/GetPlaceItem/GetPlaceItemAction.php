<?php

namespace Hedonist\Actions\Place\GetPlaceItem;

use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

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
        $place = $this->placeRepository->getById($getItemRequest->getId());
        if (!$place) {
            throw new PlaceDoesNotExistException;
        }

        $category = $this->placeCategoryRepository->getById($place->category_id);
        $city = $this->cityRepository->getById($place->city_id);
        $rating = $this->placeRatingRepository->getAverage($place->id);
        $reviews = $place->reviews;
        $localization = $place->localization;
        $features = $place->features;
        $photos = $place->photos;
        $placeInfo = $place->placeInfo;

        return new GetPlaceItemResponse(
            $place, $category, $city, $rating, $localization, $reviews, $features, $photos, $placeInfo
        );
    }
}
