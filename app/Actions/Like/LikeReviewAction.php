<?php

namespace Hedonist\Actions\Like;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Like\LikeRepositoryInterface;
use Hedonist\Repositories\Like\LikeReviewCriteria;
use Hedonist\Repositories\Dislike\DislikeRepositoryInterface;
use Hedonist\Repositories\Dislike\DislikeReviewCriteria;
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class LikeReviewAction
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

    public function execute(LikeReviewRequest $request): LikeReviewResponse
    {
        $reviewId = $request->getReviewId();
        $review = $this->reviewRepository->getById($reviewId);
        if (empty($review)) {
            throw new ReviewNotFoundException();
        }
        $userId = Auth::id();

        $like = $this->likeRepository->findByCriteria(
            new LikeReviewCriteria($reviewId, $userId)
        )->first();

        $dislike = $this->dislikeRepository->findByCriteria(
            new DislikeReviewCriteria($reviewId, $userId)
        )->first();

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
        } else {
            $this->likeRepository->deleteById($like->id);
        }

        return new LikeReviewResponse();
    }
}
