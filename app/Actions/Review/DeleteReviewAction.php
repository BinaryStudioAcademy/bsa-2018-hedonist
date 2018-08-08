<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class DeleteReviewAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(DeleteReviewRequest $request): void
    {
        $this->reviewRepository->deleteById($request->getReviewId());
    }
}
