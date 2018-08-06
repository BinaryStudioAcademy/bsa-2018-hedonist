<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Repositories\Like\{LikeRepository,LikeReviewCriteria};
use Hedonist\Repositories\Dislike\{DislikeRepository,DislikeReviewCriteria};
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Dislike\Dislike;
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

    public function execute(DislikeReviewRequest $request): DislikeReviewResponse
    {        
        $reviewId = $request->getReviewId();
        $userId = Auth::id();
        $likeCriteria = new LikeReviewCriteria($reviewId, $userId);
        $like = $this->likeRepository->findByCriteria($likeCriteria);
        $dislikeCriteria = new DislikeReviewCriteria($reviewId, $userId);
        $dislike = $this->dislikeRepository->findByCriteria($dislikeCriteria);
        if ($like) {
            $this->likeRepository->deleteById($like->id);
        }
        if (empty($dislike)) {
            $dislike = new Dislike([
                'dislikeable_id' => $reviewId,
                'dislikeable_type' => Review::class,
                'user_id' => $userId
            ]);
            $this->dislikeRepository->save($dislike);
        }
        return new DislikeReviewResponse();
    }
}