<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewCollectionAction
{
    private $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = app()->make(ReviewRepositoryInterface::class);
    }

    public function execute(): GetReviewCollectionResponse
    {
        dd('od');
        $reviews = $this->reviewRepository->findAll();
        return new GetReviewCollectionResponse($reviews);
    }
}
