<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Repositories\Review\ReviewPhotoRepository;

class SaveReviewPhotoAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepository $reviewPhotoRepository)
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
        $reviewPhoto->review_id = $request->getReviewId();
        $reviewPhoto->description = $request->getDescription();
        $reviewPhoto->img_url = $request->getImgUrl();
        $reviewPhoto = $this->reviewPhotoRepository->save($reviewPhoto);
        return new SaveReviewPhotoResponse($reviewPhoto);
    }
}