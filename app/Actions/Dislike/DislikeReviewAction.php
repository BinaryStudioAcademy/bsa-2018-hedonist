<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Events\Review\ReviewUpdatedEvent;
use Hedonist\Exceptions\Review\LikeOwnReviewException;
use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Notifications\DislikeReviewNotification;
use Hedonist\Repositories\Like\{LikeRepositoryInterface,LikeReviewCriteria};
use Hedonist\Repositories\Dislike\{DislikeRepositoryInterface,DislikeReviewCriteria};
use Hedonist\Entities\Review\Review;
use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Hedonist\Events\Review\ReviewAttitudeSetEvent;
use Illuminate\Support\Facades\Gate;

class DislikeReviewAction
{
    private $likeRepository;
    private $dislikeRepository;
    private $reviewRepository;
    private $userRepository;

    public function __construct(
        LikeRepositoryInterface $likeRepository,
        DislikeRepositoryInterface $dislikeRepository,
        ReviewRepositoryInterface $reviewRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
        $this->reviewRepository = $reviewRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(DislikeReviewRequest $request): DislikeReviewResponse
    {
        $reviewId = $request->getReviewId();
        $review = $this->reviewRepository->getById($reviewId);

        if (empty($review)) {
            throw new ReviewNotFoundException();
        }

        if (Gate::denies('review.likeOrDislike', $review)) {
            throw LikeOwnReviewException::create();
        }

        $userId = Auth::id();

        $like = $this->likeRepository->findByCriteria(
            new LikeReviewCriteria($reviewId, $userId)
        )->first();

        $dislike = $this->dislikeRepository->findByCriteria(
            new DislikeReviewCriteria($reviewId, $userId)
        )->first();

        if ($like) {
            $this->likeRepository->deleteById($like->id);

            event(new ReviewAttitudeSetEvent(
                $reviewId,
                ReviewAttitudeSetEvent::LIKE_REMOVED
            ));
        }

        if (empty($dislike)) {
            $dislike = new Dislike([
                'dislikeable_id' => $reviewId,
                'dislikeable_type' => Review::class,
                'user_id' => $userId
            ]);

            $this->dislikeRepository->save($dislike);

            $notifiableUser = $this->userRepository->getById($review->user_id);

            if ((bool) $notifiableUser->info->notifications_receive === true
                && Auth::user() !== $notifiableUser->id
            ) {
                $notifiableUser->notify(new DislikeReviewNotification($review, Auth::user()));
            }

            event(new ReviewAttitudeSetEvent(
                $reviewId,
                ReviewAttitudeSetEvent::DISLIKE_ADDED
            ));
        } else {
            $this->dislikeRepository->deleteById($dislike->id);

            event(new ReviewAttitudeSetEvent(
                $reviewId,
                ReviewAttitudeSetEvent::DISLIKE_REMOVED
            ));
        }

        event(new ReviewUpdatedEvent($reviewId));

        return new DislikeReviewResponse();
    }
}
