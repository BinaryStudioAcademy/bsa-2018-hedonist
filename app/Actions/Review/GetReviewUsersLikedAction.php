<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewUsersLikedAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(GetReviewUsersLikedRequest $request): GetReviewUsersLikedResponse
    {
        $likes = $this->reviewRepository->getById($request->getReviewId())->likes();
        $users = [];
        foreach ($likes as $like) {
            $users[] = $like->user();
        }

        return new GetReviewUsersLikedResponse($users);
    }
}
