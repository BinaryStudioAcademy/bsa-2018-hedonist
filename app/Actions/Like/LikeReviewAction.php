<?php

namespace Hedonist\Actions\Like;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Like\{LikeRepository,LikeReviewCriteria};
use Hedonist\Repositories\Dislike\{DislikeRepository,DislikeReviewCriteria};
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Hedonist\Repositories\Review\ReviewRepository;
use Illuminate\Support\Facades\Auth;

class LikeReviewAction
{
    private $likeRepository;
    private $dislikeRepository;
    private $reviewRepository;

    public function __construct(
        LikeRepository $likeRepository,
        DislikeRepository $dislikeRepository,
        ReviewRepository $reviewRepository
    ) {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(LikeReviewRequest $request): LikeReviewResponse
    {        
        $reviewId = $request->getReviewId();
        $review = $this->reviewRepository->getById($request->getReviewId());
        if (empty($review)) {
            throw new ReviewNotFoundException();
        }
        $userId = Auth::id();
        $likeCriteria = new LikeReviewCriteria($reviewId, $userId);
        $like = $this->likeRepository->findByCriteria($likeCriteria)->first();
        $dislikeCriteria = new DislikeReviewCriteria($reviewId, $userId);
        $dislike = $this->dislikeRepository->findByCriteria($dislikeCriteria)->first();
        if ($dislike) {
            $this->dislikeRepository->deleteById($dislike->id);
        }
        if (empty($like)) {
            $like = new Like([
                'likeable_id' => $reviewId,
                'likeable_type' => Review::class,
                'user_id' => $userId
            ]);
            $this->likeRepository->save($like);
        }
        return new LikeReviewResponse();
    }
}