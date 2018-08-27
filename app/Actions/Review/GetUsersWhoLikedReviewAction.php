<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Like\{
    LikeRepositoryInterface,
    ByReviewWithUsersCriteria
};

class GetUsersWhoLikedReviewAction
{
    private $likeRepository;

    public function __construct(LikeRepositoryInterface $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function execute(GetUsersWhoLikedReviewRequest $request): GetUsersWhoLikedReviewResponse
    {
        $likes = $this->likeRepository->findByCriteria(
            new ByReviewWithUsersCriteria($request->getReviewId())
        );
        $users = $likes->pluck('user'); 

        return new GetUsersWhoLikedReviewResponse($users);
    }
}
