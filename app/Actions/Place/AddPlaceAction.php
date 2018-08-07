<?php

namespace Hedonist\Actions\Place;


use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\PlaceExceptions\PlaceAddInvalidException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\PlaceExceptions\PlaceCreatorDoesNotExistException;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

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
        $validation = $this->validateRequest($placeRequest);
        $creator = $this->userRepository->getById($placeRequest->getCreatorId());
        $category = $this->placeCategoryRepository->getById($placeRequest->getCategoryId());
        $city = $this->cityRepository->getById($placeRequest->getCityId());
        if ($validation->fails()) {
            throw new PlaceAddInvalidException($validation->getMessageBag()->setFormat());
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

        $place = $this->placeRepository->save(new Place([
            'creator_id'  => $creator->id,
            'category_id' => $category->id,
            'city_id'     => $city->id,
            'longitude'   => $placeRequest->getLongitude(),
            'latitude'    => $placeRequest->getLatitude(),
            'zip'         => $placeRequest->getZip(),
            'address'     => $placeRequest->getAddress(),
        ]));

        return new AddPlaceResponse(
            $place->id,
            $place->creator->email,
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

    private function validateRequest(AddPlaceRequest $request): Validator
    {
        return ValidatorFacade::make($request->toArray(), [
            'longitude'   => 'required|numeric|min:-180|max:180',
            'latitude'    => 'required|numeric|min:-90|max:90',
            'zip'         => 'required|numeric|min:0',
            'address'     => 'required|max:255',
            'creator_id'  => 'required|numeric|min:1',
            'category_id' => 'required|numeric|min:1',
            'city_id'     => 'required|numeric|min:1',
        ]);
    }
}
