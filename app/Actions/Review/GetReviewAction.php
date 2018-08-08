<?php

namespace Hedonist\Actions\Review;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(GetReviewRequest $request): GetReviewResponse
    {
        $review = $this->reviewRepository->getById($request->getReviewId());
        if ($review === null) {
            throw new ReviewNotFoundException('Review not found!');
        }
        return new GetReviewResponse($review);
    }
}
