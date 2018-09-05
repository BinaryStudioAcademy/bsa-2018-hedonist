<?php

namespace Hedonist\Actions\Review\GetLikedDislikedByUserReviews;

use Hedonist\Repositories\Like\{
    LikeRepositoryInterface,
    ByReviewsAndUserCriteria as LikeByReviewsAndUserCriteria
};
use Hedonist\Repositories\Dislike\{
    DislikeRepositoryInterface,
    ByReviewsAndUserCriteria as DislikeByReviewsAndUserCriteria
};
use Illuminate\Support\Facades\Auth;

class GetLikedDislikedByUserReviewsAction
{
    private $likeRepository;
    private $dislikeRepository;

    public function __construct(
        LikeRepositoryInterface $likeRepository,
        DislikeRepositoryInterface $dislikeRepository
    ) {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(GetLikedDislikedByUserReviewsRequest $request): GetLikedDislikedByUserReviewsResponse
    {
        $reviewsIds = $request->getReviews()->pluck('id')->toArray();

        $likedReviewsIds = $this->likeRepository->findByCriteria(
            new LikeByReviewsAndUserCriteria(
                $reviewsIds,
                Auth::id()
            )
        )->pluck('likeable_id')->toArray();

        $dislikedReviewsIds = $this->dislikeRepository->findByCriteria(
            new DislikeByReviewsAndUserCriteria(
                $reviewsIds,
                Auth::id()
            )
        )->pluck('dislikeable_id')->toArray();

        return new GetLikedDislikedByUserReviewsResponse($likedReviewsIds, $dislikedReviewsIds);
    }
}