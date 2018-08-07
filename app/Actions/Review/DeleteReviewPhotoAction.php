<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewPhotoRepository;

class DeleteReviewPhotoAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepository $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(DeleteReviewPhotoRequest $request): DeleteReviewPhotoResponse
    {
        $this->reviewPhotoRepository->deleteById($request->getId());
        return new DeleteReviewPhotoResponse();
    }
}