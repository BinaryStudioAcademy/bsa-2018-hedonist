<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepository;

class DeleteReviewAction
{
    private $reviewRepository;

    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(DeleteReviewRequest $request): void
    {
        $this->reviewRepository->deleteById($request->getReviewId());
    }
}
