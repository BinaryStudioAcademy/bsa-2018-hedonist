<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class DeleteReviewAction
{
    private $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = app()->bind(ReviewRepositoryInterface::class);
    }

    public function execute(DeleteReviewRequest $request): void
    {
        $this->reviewRepository->deleteById($request->getReviewId());
    }
}
