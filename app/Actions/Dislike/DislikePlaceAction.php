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
        $like = $this->likeRepository->model()->where([
            ['likeable_id', $request->getPlaceId()],
            ['likeable_type', 'places']
        ])->get();
        $dislike = $this->dislikeRepository->model()->where([
            ['dislikeable_id', $request->getPlaceId()],
            ['dislikeable_type', 'places']
        ])->get();
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