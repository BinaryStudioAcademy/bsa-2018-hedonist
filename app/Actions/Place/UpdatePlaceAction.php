<?php

namespace Hedonist\Actions\Place;


use Hedonist\Exceptions\PlaceExceptions\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCreatorDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceUpdateInvalidException;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;

class UpdatePlaceAction
{
    protected $placeRepository;
    protected $userRepository;
    protected $cityRepository;
    protected $placeCategoryRepository;
    protected $updatePlaceValidator;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        UserRepositoryInterface $userRepository,
        CityRepositoryInterface $cityRepository,
        UpdatePlaceValidator $updatePlaceValidator,
        PlaceCategoryRepositoryInterface $placeCategoryRepository
    ) {
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->placeCategoryRepository = $placeCategoryRepository;
        $this->updatePlaceValidator = $updatePlaceValidator;
    }

    public function execute(UpdatePlaceRequest $placeRequest): UpdatePlaceResponse
    {
        $validation = $this->updatePlaceValidator->validate($placeRequest);
        if ($validation->fails()) {
            throw new PlaceUpdateInvalidException($validation->getMessageBag()->setFormat());
        }

        if (!$place = $this->placeRepository->getById($placeRequest->getId())) {
            throw new PlaceDoesNotExistException;
        }

        if (!$creator = $this->userRepository->getById($placeRequest->getCreatorId())) {
            throw new PlaceCreatorDoesNotExistException;
        }

        if (!$category = $this->placeCategoryRepository->getById($placeRequest->getCategoryId())) {
            throw new PlaceCategoryDoesNotExistException;
        }

        if (!$city = $this->cityRepository->getById($placeRequest->getCityId())) {
            throw new PlaceCityDoesNotExistException;
        }

        $place->creator_id = $creator->id;
        $place->category_id = $category->id;
        $place->city_id = $city->id;
        $place->longitude = $placeRequest->getLongitude();
        $place->latitude = $placeRequest->getLatitude();
        $place->zip = $placeRequest->getZip();
        $place->address = $placeRequest->getAddress();
        $place = $this->placeRepository->save($place);

        return new UpdatePlaceResponse(
            $place->id,
            $place->creator->email,    // TODO here should be a userInfo->username loaded from user_info
            $place->category->name,
            $place->city->name,
            $place->longitude,
            $place->latitude,
            $place->zip,
            $place->address,
            $place->created_at,
            $place->updated_at
        );
    }
}
