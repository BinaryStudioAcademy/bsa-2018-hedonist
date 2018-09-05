<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Repositories\Review\ReviewPhotoRepository;
use Hedonist\Repositories\Review\ReviewPhotoRepositoryInterface;
use Hedonist\Services\FileNameGenerator;
use Illuminate\Support\Facades\Storage;
use Hedonist\Events\Review\ReviewPhotoAddEvent;

class SaveReviewPhotoAction
{
    const FILE_STORAGE = 'upload/review/';

    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepositoryInterface $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(SaveReviewPhotoRequest $request): SaveReviewPhotoResponse
    {
        $id = $request->getId();
        if (!$id) {
            $reviewPhoto = new ReviewPhoto;
        } else {
            $reviewPhoto = $this->reviewPhotoRepository->getById($id);
        }
        $file = $request->getImg();
        $fileNameGenerator = new FileNameGenerator($file);
        $newFileName = $fileNameGenerator->generateFileName();
        Storage::disk()->putFileAs(self::FILE_STORAGE, $file, $newFileName, 'public');
        list($width, $height) = getimagesize($file);
        $reviewPhoto->review_id = $request->getReviewId();
        $reviewPhoto->description = $request->getDescription();
        $reviewPhoto->img_url = Storage::disk()->url(self::FILE_STORAGE . $newFileName);
        $reviewPhoto->width = $width;
        $reviewPhoto->height = $height;
        $reviewPhoto = $this->reviewPhotoRepository->save($reviewPhoto);

        broadcast(new ReviewPhotoAddEvent($reviewPhoto))->toOthers();

        return new SaveReviewPhotoResponse($reviewPhoto);
    }
}
