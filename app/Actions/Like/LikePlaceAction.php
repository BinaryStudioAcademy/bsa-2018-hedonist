<?php

namespace Hedonist\Actions\Like;

use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
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
        $like = $this->likeRepository->model()->where([
            ['likeable_id', $request->getPlaceId()],
            ['likeable_type', 'places']
        ])->get();
        $dislike = $this->dislikeRepository->model()->where([
            ['dislikeable_id', $request->getPlaceId()],
            ['dislikeable_type', 'places']
        ])->get();
        if ($dislike) {
            $this->dislikeRepository->deleteById($dislike->id);
        }
        if (empty($like)) {
            $like = new Like([
                'likeable_id' => $request->getPlaceId(),
                'likeable_type' => 'places',
                'user_id' => Auth::id()
            ]);
            $this->likeRepository->save($like);
        }
        return new LikePlaceResponse();
    }
}