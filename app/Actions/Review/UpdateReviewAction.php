<?php

namespace Hedonist\Actions\Review;

//use Hedonist\Repositories\Review\ReviewRepository;

class UpdateReviewAction
{
    private $reviewRepository;

    /* ReviewRepository does NOT created at the moment */
    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(EditReviewRequest $request): EditReviewResponse
    {
        $review = $this->reviewRepository->save(
            new Review(
                $request->getTitle(),
                $request->getBody()
            )
        );
        return new EditReviewResponse($review);
    }
}
