<?php

namespace Hedonist\Actions\Like;

use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Repositories\Like\{LikeRepositoryInterface,LikeReviewCriteria};
use Hedonist\Repositories\Dislike\{DislikeRepositoryInterface,DislikeReviewCriteria};
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Like\Like;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Hedonist\Events\Review\ReviewAttitudeSetEvent;

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
            event(new ReviewAttitudeSetEvent(
                $reviewId,
                ReviewAttitudeSetEvent::DISLIKE_REMOVED
            ));
            
            $this->dislikeRepository->deleteById($dislike->id);
        }
        if (empty($like)) {
            event(new ReviewAttitudeSetEvent(
                $reviewId,
                ReviewAttitudeSetEvent::LIKE_ADDED
            ));
            
            $like = new Like([
                'likeable_id' => $reviewId,
                'likeable_type' => Review::class,
                'user_id' => $userId
            ]);
            $this->likeRepository->save($like);
        } else {
            event(new ReviewAttitudeSetEvent(
                $reviewId,
                ReviewAttitudeSetEvent::LIKE_REMOVED
            ));
            
            $this->likeRepository->deleteById($like->id);
        }
        
        return new LikeReviewResponse();
    }
}
