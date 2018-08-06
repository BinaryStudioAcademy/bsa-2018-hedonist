<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewCollectionAction
{
    private $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = app()->bind(ReviewRepositoryInterface::class);
    }

    public function execute(): GetReviewCollectionResponse
    {
        $reviews = $this->reviewRepository->findAll();
        return new GetReviewCollectionResponse($reviews);
    }
}
