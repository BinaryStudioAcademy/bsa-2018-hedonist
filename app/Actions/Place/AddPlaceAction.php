<?php

namespace Hedonist\Actions\Place;


use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\PlaceExceptions\PlaceAddInvalidException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCreatorDoesNotExistException;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;

class AddPlaceAction
{
    protected $placeRepository;
    protected $userRepository;
    protected $placeCategoryRepository;
    protected $addPlaceValidator;

    public function __construct(
        PlaceRepositoryInterface $placeRepository,
        UserRepositoryInterface $userRepository,
        PlaceCategoryRepositoryInterface $placeCategoryRepository,
        AddPlaceValidator $addPlaceValidator
    ) {
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->placeCategoryRepository = $placeCategoryRepository;
        $this->addPlaceValidator = $addPlaceValidator;
    }

    public function execute(AddPlaceRequest $placeRequest): AddPlaceResponse
    {
        $validation = $this->addPlaceValidator->validate($placeRequest);
        if ($validation->fails()) {
            throw new PlaceAddInvalidException($validation->getMessageBag()->setFormat());
        }

        if (!$creator = $this->userRepository->getById($placeRequest->getCreatorId())) {
            throw new PlaceCreatorDoesNotExistException;
        }

        if (!$category = $this->placeCategoryRepository->getById($placeRequest->getCategoryId())) {
            throw new PlaceCategoryDoesNotExistException;
        }

//        if (!$city = $this->userRepository->getById($placeRequest->getCreatorId())) {
//             throw new PlaceCityDoesNotExistException; // TODO city repo required
//        }

        $place = $this->placeRepository->save(new Place([
            'creator_id' => $creator->id,
            'category_id' => $category->id,
            'city_id' => $placeRequest->getCityId(),
            'longitude' => $placeRequest->getLongitude(),
            'latitude' => $placeRequest->getLatitude(),
            'zip' => $placeRequest->getZip(),
            'address' => $placeRequest->getAddress(),
        ]));

        return new AddPlaceResponse(
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
