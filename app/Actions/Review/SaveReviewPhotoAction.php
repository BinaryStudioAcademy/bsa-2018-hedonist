<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Repositories\Review\ReviewPhotoRepository;
use Hedonist\Repositories\Review\ReviewPhotoRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class SaveReviewPhotoAction
{
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
        $newFileName = time() . '_' . mt_rand() . '.' . $file->extension();
        $file->storeAs('upload/review', $newFileName, 'public');
        $reviewPhoto->review_id = $request->getReviewId();
        $reviewPhoto->description = $request->getDescription();
        $reviewPhoto->img_url = Storage::url('upload/review/' . $newFileName);
        $reviewPhoto = $this->reviewPhotoRepository->save($reviewPhoto);

        return new SaveReviewPhotoResponse($reviewPhoto);
    }
}