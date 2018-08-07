<?php

namespace Hedonist\Actions\Place\AddPlace;

use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\PlaceExceptions\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCreatorDoesNotExistException;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;

class AddPlaceAction
{
    protected $placeRepository;
    protected $userRepository;
    protected $cityRepository;
    protected $placeCategoryRepository;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        UserRepositoryInterface $userRepository,
        PlaceCategoryRepositoryInterface $placeCategoryRepository,
        CityRepositoryInterface $cityRepository
    ) {
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(AddPlaceRequest $placeRequest): AddPlaceResponse
    {
        $creator = $this->userRepository->getById($placeRequest->getCreatorId());
        $category = $this->placeCategoryRepository->getById($placeRequest->getCategoryId());
        $city = $this->cityRepository->getById($placeRequest->getCityId());
        if (!$creator) {
            throw new PlaceCreatorDoesNotExistException;
        }

        if (!$category) {
            throw new PlaceCategoryDoesNotExistException;
        }

        if (!$city) {
            throw new PlaceCityDoesNotExistException;
        }

        $place = $this->placeRepository->save(new Place([
            'creator_id'  => $creator->id,
            'category_id' => $category->id,
            'city_id'     => $city->id,
            'longitude'   => $placeRequest->getLongitude(),
            'latitude'    => $placeRequest->getLatitude(),
            'zip'         => $placeRequest->getZip(),
            'address'     => $placeRequest->getAddress(),
        ]));

        return new AddPlaceResponse($place);
    }
}
