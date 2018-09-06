<?php

namespace Hedonist\Events\Review;

use Illuminate\Foundation\Events\Dispatchable;

class ReviewAttitudeSetEvent
{
    use Dispatchable;

    const LIKE_ADDED      = 'likeAdded';
    const LIKE_REMOVED    = 'likeRemoved';
    const DISLIKE_ADDED   = 'dislikeAdded';
    const DISLIKE_REMOVED = 'dislikeRemoved';

    private $reviewId;
    private $attitudeType;
    
    public function __construct(int $reviewId, string $attitudeType)
    {
        $this->reviewId     = $reviewId;
        $this->attitudeType = $attitudeType;
    }

    public function getReviewId(): int
    {
        return $this->reviewId;
    }

    public function getAttitudeType(): string
    {
        return $this->attitudeType;
    }
}
