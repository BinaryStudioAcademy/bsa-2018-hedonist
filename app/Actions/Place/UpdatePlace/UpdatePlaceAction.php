<?php

namespace Hedonist\Actions\Place\UpdatePlace;

use Hedonist\Exceptions\PlaceExceptions\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCreatorDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceUpdateInvalidException;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class UpdatePlaceAction
{
    protected $placeRepository;
    protected $userRepository;
    protected $cityRepository;
    protected $placeCategoryRepository;

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
        $creator    = $this->userRepository->getById($placeRequest->getCreatorId());
        $place      = $this->placeRepository->getById($placeRequest->getId());
        $category   = $this->placeCategoryRepository->getById($placeRequest->getCategoryId());
        $city       = $this->cityRepository->getById($placeRequest->getCityId());

        if (!$place) {
            throw new PlaceDoesNotExistException;
        }

        if (!$creator) {
            throw new PlaceCreatorDoesNotExistException;
        }

        if (!$category) {
            throw new PlaceCategoryDoesNotExistException;
        }

        if (!$city) {
            throw new PlaceCityDoesNotExistException;
        }

        $place->creator_id  = $creator->id;
        $place->category_id = $category->id;
        $place->city_id     = $city->id;
        $place->longitude   = $placeRequest->getLongitude();
        $place->latitude    = $placeRequest->getLatitude();
        $place->zip         = $placeRequest->getZip();
        $place->address     = $placeRequest->getAddress();

        $place = $this->placeRepository->save($place);
        return new UpdatePlaceResponse($place);
    }
}
