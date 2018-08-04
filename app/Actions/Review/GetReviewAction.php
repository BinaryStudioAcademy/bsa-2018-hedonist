<?php

namespace Hedonist\Actions\Review;

//use Hedonist\Repositories\Review\ReviewRepository;

class GetReviewAction
{
    private $reviewRepository;

    /* ReviewRepository does NOT created at the moment */
    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(GetReviewRequest $request): GetReviewResponse
    {
        $review = $this->reviewRepository->getById($request->getReviewId());
        return new GetReviewResponse($review);
    }
}
