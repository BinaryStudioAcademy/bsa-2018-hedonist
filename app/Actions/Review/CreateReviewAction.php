<?php

namespace Hedonist\Actions\Review;

//use Hedonist\Repositories\Review\ReviewRepository;

class CreateReviewAction
{
    private $reviewRepository;

    /* ReviewRepository does NOT created at the moment */
    public function __construct(ReviewRepository $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(CreateReviewRequest $request): CreateReviewResponse
    {
        $review = $this->reviewRepository->save(
            new Review(
                $request->getTitle(),
                $request->getBody()
            )
        );
        return new CreateReviewResponse($review);
    }
}
