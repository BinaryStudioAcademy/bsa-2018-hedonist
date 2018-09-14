<?php

namespace Hedonist\Listeners\Review;

use Hedonist\Events\Review\ReviewUpdatedEvent;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;

class ReviewUpdatedEventListener
{
    private $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function handle(ReviewUpdatedEvent $event)
    {
        $review = $this->reviewRepository->getById($event->getReviewId());

        if (env('APP_ENV') !== 'testing') {
            $review->document()->save();
        }
    }
}
