<?php

namespace Hedonist\Actions\Like;

use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Place\PlaceRepository;
use Illuminate\Support\Facades\Auth;
use Hedonist\Entities\Like\LikeStatus;

class GetLikedPlaceAction
{
    private $likeRepository;
    private $dislikeRepository;
    private $placeRepository;

    public function __construct(
        LikeRepository $likeRepository,
        DislikeRepository $dislikeRepository,
        PlaceRepository $placeRepository
    ) {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
        $this->placeRepository = $placeRepository;
    }

    public function execute(GetLikedPlaceRequest $request): GetLikedPlaceResponse
    {
        $liked = LikeStatus::none();
        $placeId = $request->getPlaceId();
        $userId = Auth::id();
        $place = $this->placeRepository->getById($placeId);
        if ($place === null) {
            throw new PlaceNotFoundException();
        }

        $like = $this->likeRepository->findByUserAndPlace($userId, $placeId);
        if ($like) {
            $liked = LikeStatus::liked();
        } else {
            $dislike = $this->dislikeRepository->findByUserAndPlace($userId, $placeId);
            if ($dislike) {
                $liked = LikeStatus::disliked();
            }
        }
        
        return new GetLikedPlaceResponse($liked->value());
    }
}