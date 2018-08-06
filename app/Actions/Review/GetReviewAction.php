<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewAction
{
    private $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = app()->make(ReviewRepositoryInterface::class);
    }

    public function execute(GetReviewRequest $request): GetReviewResponse
    {
        $review = $this->reviewRepository->getById($request->getReviewId());
        if ($review === null) {
            throw new \LogicException('Review not found!');
        }
        return new GetReviewResponse($review);
    }
}
