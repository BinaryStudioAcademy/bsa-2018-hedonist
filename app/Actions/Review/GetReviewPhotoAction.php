<?php

namespace Hedonist\Actions\Review;


use Hedonist\Exceptions\Review\ReviewPhotoExistsException;
use Hedonist\Repositories\Review\ReviewPhotoRepository;

class GetReviewPhotoAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepository $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(GetReviewPhotoRequest $request): GetReviewPhotoResponse
    {
        $id = $request->getId();
        $reviewPhoto = $this->reviewPhotoRepository->getById($id);
        if (!$reviewPhoto) {
            throw new ReviewPhotoExistsException('Review photo not found.');
        }
        return new GetReviewPhotoResponse($reviewPhoto);
    }
}