<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\Review;
use Hedonist\Repositories\Review\ReviewRepository;

class UpdateReviewAction
{
    private $reviewRepository;

    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(UpdateReviewRequest $request): UpdateReviewResponse
    {
        $review = $this->reviewRepository->save(
            new Review(
                [
                    'user_id'       => $request->getUserId(),
                    'place_id'      => $request->getPlaceId(),
                    'description'   => $request->getDescription()
                ]
            )
        );
        return new UpdateReviewResponse($review);
    }
}
