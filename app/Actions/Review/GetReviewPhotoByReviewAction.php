<?php

namespace Hedonist\Actions\Review;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewPhotoByReviewAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(GetReviewPhotoByReviewRequest $request): GetReviewPhotoByReviewResponse
    {
        $review = $this->reviewRepository->getById($request->getReviewId());
        if (!$review) {
            throw ReviewNotFoundException::create();
        }
        $reviewPhotos = $review->photos()->getResults();
        return new GetReviewPhotoByReviewResponse($reviewPhotos);
    }
}