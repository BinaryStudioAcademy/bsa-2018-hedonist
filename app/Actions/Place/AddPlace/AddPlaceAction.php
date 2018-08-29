<?php

namespace Hedonist\Actions\Place\AddPlace;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\Place\Location;
use Illuminate\Support\Facades\Storage;
use Hedonist\Entities\Place\PlacePhoto;
use Hedonist\Services\FileNameGenerator;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\City\CityRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Exceptions\Place\PlaceLocationInvalidException;
use Hedonist\Exceptions\Place\PlaceCityDoesNotExistException;
use Hedonist\Repositories\Place\PlacePhotoRepositoryInterface;
use Hedonist\Exceptions\Place\PlaceCreatorDoesNotExistException;
use Hedonist\Exceptions\Place\PlaceCategoryDoesNotExistException;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;

class AddPlaceAction
{
    const FILE_STORAGE = 'upload/place';
    const DESCRIPTION_DEFAULT = 'Place owner\'s photo.';

    private $userRepository;
    private $cityRepository;
    private $placeRepository;
    private $placePhotoRepository;
    private $placeCategoryRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CityRepositoryInterface $cityRepository,
        PlaceRepositoryInterface $placeRepository,
        PlacePhotoRepositoryInterface $placePhotoRepository,
        PlaceCategoryRepositoryInterface $placeCategoryRepository
    ) {
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->placePhotoRepository = $placePhotoRepository;
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

        foreach ($placeRequest->getPhotos() as $photo) {
            $fileNameGenerator = new FileNameGenerator($photo);
            $fileName = $fileNameGenerator->generateFileName();
            $path = Storage::putFileAs(self::FILE_STORAGE, $photo, $fileName, 'public');
            list($width, $height) = getimagesize($photo);
            $this->placePhotoRepository->save(new PlacePhoto([
                'creator_id'  => $creator->id,
                'img_url'     => $path,
                'description' => self::DESCRIPTION_DEFAULT,
                'place_id'    => $place->id,
                'width'       => $width,
                'height'      => $height
            ]));
        }

        return new AddPlaceResponse($place);
    }
}
