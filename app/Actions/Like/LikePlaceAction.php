<?php

namespace Hedonist\Actions\Like;

use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Place\Place;
use Illuminate\Support\Facades\Auth;

class LikePlaceAction
{
    private $likeRepository;
    private $dislikeRepository;

    public function __construct(LikeRepository $likeRepository, DislikeRepository $dislikeRepository)
    {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
    }

    public function execute(LikePlaceRequest $request): LikePlaceResponse
    {
        $like = $this->likeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        $dislike = $this->dislikeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        if ($dislike) {
            $this->dislikeRepository->deleteById($dislike->id);
        }
        if (empty($like)) {
            $like = new Like([
                'likeable_id' => $request->getPlaceId(),
                'likeable_type' => Place::class,
                'user_id' => Auth::id()
            ]);
            $this->likeRepository->save($like);
        }
        
        return new LikePlaceResponse();
    }
}