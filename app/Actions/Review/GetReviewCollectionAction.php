<?php

namespace Hedonist\Actions\Review;

//use Hedonist\Repositories\Review\ReviewRepository;

class GetReviewCollectionAction
{
    private $reviewRepository;

    /* ReviewRepository does NOT created at the moment */
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
