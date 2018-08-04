<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Illuminate\Support\Facades\Auth;

class DislikePlaceAction
{
    private $likeRepository;
    private $dislikeRepository;

    public function __construct(LikeRepository $likeRepository, DislikeRepository $dislikeRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(DislikePlaceRequest $request): DislikePlaceResponse
    {
        $like = $this->likeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        $dislike = $this->dislikeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        if ($like) {
            $this->likeRepository->deleteById($like->id);
        }
        if (empty($dislike)) {
            $dislike = new Dislike([
                'dislikeable_id' => $request->getPlaceId(),
                'dislikeable_type' => 'places',
                'user_id' => Auth::id()
            ]);
            $this->dislikeRepository->save($dislike);
        }

        return new DislikePlaceResponse();
    }
}