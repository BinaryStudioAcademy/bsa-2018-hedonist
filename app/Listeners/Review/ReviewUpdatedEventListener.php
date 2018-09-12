<?php

namespace Hedonist\Listeners\Review;

use Hedonist\Events\Review\ReviewUpdatedEvent;

class ReviewUpdatedEventListener
{
    public function handle(ReviewUpdatedEvent $event)
    {
        $review = $event->getReview();

        if (env('APP_ENV') !== 'testing') {
            $review->document()->save();
        }
    }
}
