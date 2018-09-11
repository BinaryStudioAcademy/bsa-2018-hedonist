<?php

namespace Hedonist\Events\Review;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Hedonist\Entities\Review\ReviewPhoto;

class ReviewPhotoAddEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reviewPhoto;
    
    public function __construct(ReviewPhoto $reviewPhoto)
    {
        $this->reviewPhoto = $reviewPhoto;
    }

    public function broadcastAs(): string
    {
        return 'review.photo.added';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('reviews');
    }
}
