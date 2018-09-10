<?php

namespace Hedonist\Events\Review;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ReviewAttitudeBroadcastEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $reviewId;
    public $attitudeType;
    
    public function __construct(int $reviewId, string $attitudeType)
    {
        $this->reviewId     = $reviewId;
        $this->attitudeType = $attitudeType;
    }

    public function broadcastAs(): string
    {
        return 'attitude.set';
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('review.' . $this->reviewId);
    }
}
