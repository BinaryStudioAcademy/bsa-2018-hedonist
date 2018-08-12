<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewCollectionAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(): GetReviewCollectionResponse
    {
        $reviews = $this->reviewRepository->findAll();

        return new GetReviewCollectionResponse($reviews);
    }
}
