<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepository;

class GetReviewCollectionAction
{
    private $reviewRepository;

    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(): GetReviewCollectionResponse
    {
        $reviews = $this->reviewRepository->findAll();
        return new GetReviewCollectionResponse($reviews);
    }
}
