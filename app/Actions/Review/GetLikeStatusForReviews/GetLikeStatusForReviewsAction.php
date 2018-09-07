<?php

namespace Hedonist\Actions\Review\GetLikeStatusForReviews;

use Hedonist\Entities\Like\LikeStatus;
use Hedonist\Repositories\Like\{
    LikeRepositoryInterface,
    ByReviewsAndUserCriteria as LikeByReviewsAndUserCriteria
};
use Hedonist\Repositories\Dislike\{
    DislikeRepositoryInterface,
    ByReviewsAndUserCriteria as DislikeByReviewsAndUserCriteria
};
use Illuminate\Support\Facades\Auth;

class GetLikeStatusForReviewsAction
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

    public function execute(GetLikeStatusForReviewsRequest $request): GetLikeStatusForReviewsResponse
    {
        $reviews = $request->getReviewCollection();
        $reviewsIds = $reviews->pluck('id')->toArray();

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

        foreach ($reviews as $key=>$review) {
            if (in_array($review->id, $likedReviewsIds)) {
                $reviews[$key]->like_status = LikeStatus::LIKED;
            } elseif (in_array($review->id, $dislikedReviewsIds)) {
                $reviews[$key]->like_status = LikeStatus::DISLIKED;
            } else {
                $reviews[$key]->like_status = LikeStatus::NONE;
            }
        }

        return new GetLikeStatusForReviewsResponse($reviews);
    }
}