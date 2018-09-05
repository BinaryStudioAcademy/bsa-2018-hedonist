<?php

namespace Hedonist\Events\Attitude;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AttitudeSetEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    const LIKE_ADDED      = 'likeAdded';
    const LIKE_REMOVED    = 'likeRemoved';
    const DISLIKE_ADDED   = 'dislikeAdded';
    const DISLIKE_REMOVED = 'dislikeRemoved';

    public $reviewId;
    public $attitudeType;
    
    public function __construct(int $reviewId, string $type)
    {
        $this->reviewId     = $reviewId;
        $this->attitudeType = $type;
    }

    public function broadcastAs(): string
    {
        return 'attitude.set';
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('reviews');
    }
}
