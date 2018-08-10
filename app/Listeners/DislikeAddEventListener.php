<?php

namespace Hedonist\Listeners;

use Hedonist\Events\Dislike\DislikeAddEvent;
use Hedonist\Repositories\Like\LikeRepositoryInterface;

class DislikeAddEventListener
{
    private $likeRepository;

    public function __construct(LikeRepositoryInterface $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function handle(DislikeAddEvent $event)
    {
        $dislike = $event->getDislike();
        $like = $this->likeRepository
            ->findByUserAndPlace($dislike->user_id, $dislike->dislikeable_id);
        if ($like) {
            $this->likeRepository->deleteById($like->id);
        }
    }
}
