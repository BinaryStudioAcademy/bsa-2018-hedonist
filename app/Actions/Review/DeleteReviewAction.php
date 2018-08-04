<?php

namespace Hedonist\Actions\Review;

//use Hedonist\Repositories\Review\ReviewRepository;

class DeleteReviewAction
{
    private $reviewRepository;

    /* ReviewRepository does NOT created at the moment */
    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(DeleteReviewRequest $request)
    {
        $this->reviewRepository->deleteById($request->getReviewId());
    }
}
