<?php

namespace Hedonist\Actions\Place\AddPlace;

use Hedonist\Entities\Place\Location;
use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Exceptions\Place\PlaceCategoryDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceCityDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceCreatorDoesNotExistException;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;

class AddPlaceAction
{
    private $placeRepository;
    private $userRepository;
    private $cityRepository;
    private $placeCategoryRepository;

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

        /* firstOrCreate */
        $city = $this->cityRepository->findByNameAndLocation(
            $placeRequest->getCity()['name'],
            $placeRequest->getCity()['lng'],
            $placeRequest->getCity()['lat']
        );

        try {
            $location = new Location($placeRequest->getLongitude(), $placeRequest->getLatitude());
        } catch (\InvalidArgumentException $e) {
            throw new PlaceLocationInvalidException($e->getMessage());
        }

        if (!$creator) {
            throw new PlaceCreatorDoesNotExistException;
        }

        if (!$category) {
            throw new PlaceCategoryDoesNotExistException;
        }

        /* Delete with Exception, city CANNOT be null */
        if (!$city) {
            throw new PlaceCityDoesNotExistException;
        }

        $place = $this->placeRepository->save(new Place([
            'creator_id'  => $creator->id,
            'category_id' => $category->id,
            'city_id'     => $city->id,
            'longitude'   => $location->getLongitude(),
            'latitude'    => $location->getLatitude(),
            'zip'         => $placeRequest->getZip(),
            'address'     => $placeRequest->getAddress(),
            'phone'       => $placeRequest->getPhone(),
            'website'     => $placeRequest->getWebsite(),
        ]));

        return new AddPlaceResponse($place);
    }
}
