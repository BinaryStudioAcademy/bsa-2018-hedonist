<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\Review;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class UpdateReviewAction
{
    private $reviewRepository;

    public function __construct()
    {
        $this->reviewRepository = app()->make(ReviewRepositoryInterface::class);
    }

    public function execute(UpdateReviewRequest $request, $id): UpdateReviewResponse
    {
        $review = $this->reviewRepository->getById($id);
        if (!$review) {
            $review = $this->reviewRepository->model();
        }
        $review->user_id = $request->getUserId();
        $review->place_id = $request->getPlaceId();
        $review->description = $request->getDescription();

        return new UpdateReviewResponse($this->reviewRepository->save($review));
    }
}
