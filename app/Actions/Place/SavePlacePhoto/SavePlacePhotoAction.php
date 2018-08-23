<?php

namespace Hedonist\Actions\Place;

use Hedonist\Actions\Place\SavePlacePhoto\SavePlacePhotoRequest;
use Hedonist\Actions\Place\SavePlacePhoto\SavePlacePhotoResponse;
use Hedonist\Entities\Place\PlacePhoto;
use Hedonist\Repositories\Place\PlacePhotoRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Illuminate\Support\Facades\Storage;

class SavePlacePhotoAction
{
    const FILE_STORAGE = 'upload/photo/';

    private $placePhotoRepository;

    public function __construct(PlacePhotoRepositoryInterface $placePhotoRepository)
    {
        $this->placePhotoRepository = $placePhotoRepository;
    }

    public function execute(SavePlacePhotoRequest $request): SavePlacePhotoResponse
    {
        $placePhoto = new PlacePhoto();

        $file = $request->getImg();
        $fileNameGenerator = new FileNameGenerator($file);
        $newFileName = $fileNameGenerator->generateFileName();
        Storage::disk()->putFileAs(self::FILE_STORAGE, $file, $newFileName);
        list($width, $height) = getimagesize($file);
        $placePhoto->place_id = $request->getPlaceId();
        $placePhoto->creator_id = $request->getCreatorId();
        $placePhoto->description = $request->getDescription();
        $placePhoto->img_url = Storage::disk()->url(self::FILE_STORAGE . $newFileName);
        $placePhoto->width = $width;
        $placePhoto->height = $height;
        $placePhoto = $this->placePhotoRepository->save($placePhoto);

        return new SavePlacePhotoResponse($placePhoto);
    }
}