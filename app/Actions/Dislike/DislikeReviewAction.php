<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Like\{LikeRepositoryInterface,LikeReviewCriteria};
use Hedonist\Repositories\Dislike\{DislikeRepositoryInterface,DislikeReviewCriteria};
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DislikeReviewAction
{
    private $likeRepository;
    private $dislikeRepository;
    private $reviewRepository;

    public function __construct(
        LikeRepositoryInterface $likeRepository,
        DislikeRepositoryInterface $dislikeRepository,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(DislikeReviewRequest $request): DislikeReviewResponse
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