<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Dislike\{
    DislikeRepositoryInterface,
    ByReviewWithUsersCriteria
};

class GetUsersWhoDislikedReviewAction
{
    private $dislikeRepository;

    public function __construct(DislikeRepositoryInterface $dislikeRepository)
    {
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(GetUsersWhoDislikedReviewRequest $request): GetUsersWhoDislikedReviewResponse
    {
        $dislikes = $this->dislikeRepository->findByCriteria(
            new ByReviewWithUsersCriteria($request->getReviewId())
        );
        $users = $dislikes->pluck('user');

        return new GetUsersWhoDislikedReviewResponse($users);
    }
}
