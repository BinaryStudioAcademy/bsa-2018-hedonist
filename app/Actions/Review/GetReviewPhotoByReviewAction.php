<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewPhotoRepositoryInterface;

class GetReviewPhotoByReviewAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepositoryInterface $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(GetReviewPhotoByReviewRequest $request): GetReviewPhotoByReviewResponse
    {
        $reviewPhotos = $this->reviewPhotoRepository->getByReview($request->getReviewId());

        return new GetReviewPhotoByReviewResponse($reviewPhotos);
    }
}