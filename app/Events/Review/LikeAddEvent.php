<?php

namespace Hedonist\Events\Review;

use Hedonist\Entities\Review\Review;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LikeAddEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $review;
    private $userId;

    public function __construct(Review $review, int $userId)
    {
        $this->review = $review;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        $reviewUserId = $this->review->user_id;
        return new Channel("App.User.{$reviewUserId}");
    }

    public function broadcastWith()
    {
        $reviewId = $this->review->id;
        $likeUserId = $this->userId;
        return ['message' => "User #{$likeUserId} like your review id {$reviewId}"];
    }
}
