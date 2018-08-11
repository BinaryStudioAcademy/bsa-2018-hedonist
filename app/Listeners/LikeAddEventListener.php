<?php

namespace Hedonist\Listeners;

use Hedonist\Events\Like\LikeAddEvent;
use Hedonist\Repositories\Dislike\DislikeRepositoryInterface;

class LikeAddEventListener
{
    private $dislikeRepository;

    public function __construct(DislikeRepositoryInterface $dislikeRepository)
    {
        $this->dislikeRepository = $dislikeRepository;
    }

    public function handle(LikeAddEvent $event)
    {
        $likeable = $event->getLike();
        $dislike = $this->dislikeRepository
            ->findByUserAndPlace($likeable->user_id, $likeable->likeable_id);
        if ($dislike) {
            $this->dislikeRepository->deleteById($dislike->id);
        }
    }
}
