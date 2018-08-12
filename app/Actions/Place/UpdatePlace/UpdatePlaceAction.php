<?php

namespace Hedonist\Actions\Place\UpdatePlace;

use Hedonist\Entities\Place\Location;
use Hedonist\Exceptions\PlaceExceptions\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCreatorDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceLocationInvalidException;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;

class UpdatePlaceAction
{
    private $placeRepository;
    private $userRepository;
    private $cityRepository;
    private $placeCategoryRepository;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        UserRepositoryInterface $userRepository,
        CityRepositoryInterface $cityRepository,
        PlaceCategoryRepositoryInterface $placeCategoryRepository
    ) {
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(UpdatePlaceRequest $placeRequest): UpdatePlaceResponse
    {
        $creator = $this->userRepository->getById($placeRequest->getCreatorId());
        $place = $this->placeRepository->getById($placeRequest->getId());
        $category = $this->placeCategoryRepository->getById($placeRequest->getCategoryId());
        $city = $this->cityRepository->getById($placeRequest->getCityId());

        try {
            $location = new Location($placeRequest->getLongitude(), $placeRequest->getLatitude());
        } catch (\InvalidArgumentException $e) {
            throw new PlaceLocationInvalidException($e->getMessage());
        }

        if (! $place) {
            throw new PlaceDoesNotExistException;
        }

        if (! $creator) {
            throw new PlaceCreatorDoesNotExistException;
        }

        if (! $category) {
            throw new PlaceCategoryDoesNotExistException;
        }

        if (! $city) {
            throw new PlaceCityDoesNotExistException;
        }

        $place->setLocation($location);
        $place->creator_id = $creator->id;
        $place->category_id = $category->id;
        $place->city_id = $city->id;
        $place->zip = $placeRequest->getZip();
        $place->address = $placeRequest->getAddress();
        $place->phone = $placeRequest->getPhone();
        $place->website = $placeRequest->getWebsite();

        $place = $this->placeRepository->save($place);

        return new UpdatePlaceResponse($place);
    }
}
