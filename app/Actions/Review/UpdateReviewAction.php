<?php

namespace Hedonist\Actions\Review;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class UpdateReviewAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(UpdateReviewRequest $request, $id): UpdateReviewResponse
    {
        $review = $this->reviewRepository->getById($id);
        if ($review === null) {
            throw new ReviewNotFoundException('The Review does NOT exist!');
        }
        $review->user_id = $request->getUserId();
        $review->place_id = $request->getPlaceId();
        $review->description = $request->getDescription();

        return new UpdateReviewResponse($this->reviewRepository->save($review));
    }
}
