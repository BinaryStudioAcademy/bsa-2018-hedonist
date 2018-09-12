<?php

namespace Hedonist\Listeners\Review;

use Hedonist\Events\Review\ReviewAddEvent;

class ReviewAddEventListener
{
    public function handle(ReviewAddEvent $event)
    {
        $review = $event->getReview();

        if (env('APP_ENV') !== 'testing') {
            $review->document()->save();
        }
    }
}
