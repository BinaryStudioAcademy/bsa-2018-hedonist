<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewPhotoRepository;

class GetCollectionReviewPhotoAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepository $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(): GetCollectionReviewPhotoResponse
    {
        $reviewPhotos = $this->reviewPhotoRepository->findAll();
        return new GetCollectionReviewPhotoResponse($reviewPhotos);
    }
}