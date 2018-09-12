<?php

namespace Hedonist\Listeners\Review;

use Hedonist\Events\Review\{
    ReviewAttitudeSetEvent,
    ReviewAttitudeBroadcastEvent
};

class ReviewAttitudeSetEventListener
{
    public function handle(ReviewAttitudeSetEvent $event)
    {
        broadcast(new ReviewAttitudeBroadcastEvent(
            $event->getReviewId(),
            $event->getAttitudeType()
        ))->toOthers();
    }
}
