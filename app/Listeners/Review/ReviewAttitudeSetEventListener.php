<?php

namespace Hedonist\Listeners\Review;

use Hedonist\Events\Review\{
    ReviewAttitudeSetEvent,
    ReviewAttitudeBroadcastEvent
};
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class ReviewAttitudeSetEventListener
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function handle(ReviewAttitudeSetEvent $event)
    {
        broadcast(new ReviewAttitudeBroadcastEvent(
            $event->getReviewId(),
            $event->getAttitudeType()
        ))->toOthers();

        $review = $this->reviewRepository->getById($event->getReviewId());

        $review->document()->save();
    }
}
