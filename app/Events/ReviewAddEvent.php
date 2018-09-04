<?php

namespace Hedonist\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Hedonist\Entities\Review\Review;

class ReviewAddEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $review;
    
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    public function broadcastAs(): string
    {
        return 'review.added';
    }

    public function broadcastWith(): array
    {
        return [
            'review' => [
                'id'          => $this->review->id,
                'place_id'    => $this->review->place_id,
                'user_id'     => $this->review->user_id,
                'description' => $this->review->description,
                'created_at'  => $this->review->created_at->format('Y-m-d H:i:s'),
                'updated_at'  => $this->review->updated_at->format('Y-m-d H:i:s'),
                'photos'      => $this->review->photos,
            ],
            'user' => [
                'data' => [
                    'id' => $this->review->user->id,
                    'first_name' => $this->review->user->info->first_name,
                    'last_name' => $this->review->user->info->last_name,
                    'email' => $this->review->user->email,
                    'avatar_url' => $this->review->user->avatar_url,
                ],
            ],
        ];
    }

    public function broadcastOn()
    {
        return new PrivateChannel('reviews');
    }
}
