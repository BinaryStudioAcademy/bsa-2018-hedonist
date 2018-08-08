<?php

namespace Hedonist\Actions\Review;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class UpdateReviewDescriptionAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(UpdateReviewDescriptionRequest $request, $id): UpdateReviewDescriptionResponse
    {
        $review = $this->reviewRepository->getById($id);
        if ($review === null) {
            throw ReviewNotFoundException::create();
        }
        $review->description = $request->getDescription();

        return new UpdateReviewDescriptionResponse($this->reviewRepository->save($review));
    }
}
