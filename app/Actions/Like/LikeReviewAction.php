<?php

namespace Hedonist\Actions\Like;

use Hedonist\Repositories\Like\{LikeRepository,LikeReviewCriteria};
use Hedonist\Repositories\Dislike\{DislikeRepository,DislikeReviewCriteria};
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Illuminate\Support\Facades\Auth;

class LikeReviewAction
{
    private $likeRepository;
    private $dislikeRepository;

    public function __construct(LikeRepository $likeRepository, DislikeRepository $dislikeRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(LikeReviewRequest $request): LikeReviewResponse
    {        
        $reviewId = $request->getReviewId();
        $userId = Auth::id();
        $likeCriteria = new LikeReviewCriteria($reviewId, $userId);
        $like = $this->likeRepository->findByCriteria($likeCriteria);
        $dislikeCriteria = new DislikeReviewCriteria($reviewId, $userId);
        $dislike = $this->dislikeRepository->findByCriteria($dislikeCriteria);
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