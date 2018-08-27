<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class GetReviewUsersDislikedAction
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $repository)
    {
        $this->reviewRepository = $repository;
    }

    public function execute(GetReviewUsersDislikedRequest $request): GetReviewUsersDislikedResponse
    {
        $dislikes = $this->reviewRepository->getById($request->getReviewId())->dislikes->all();
        $users = [];
        foreach ($dislikes as $dislike) {
            $users[] = $dislike->user->info;
        }

        return new GetReviewUsersDislikedResponse($users);
    }
}
