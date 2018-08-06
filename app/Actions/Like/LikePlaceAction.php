<?php

namespace Hedonist\Actions\Like;

use Hedonist\Entities\Like\Like;
use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Place\PlaceRepository;
use Illuminate\Support\Facades\Auth;

class LikePlaceAction
{
    private $likeRepository;
    private $dislikeRepository;
    private $placeRepository;

    public function __construct(
        LikeRepository $likeRepository,
        DislikeRepository $dislikeRepository,
        PlaceRepository $placeRepository
    )
    {
        $this->likeRepository = $likeRepository;
        $this->dislikeRepository = $dislikeRepository;
        $this->placeRepository = $placeRepository;
    }

    public function execute(LikePlaceRequest $request): LikePlaceResponse
    {
        $place = $this->placeRepository->getById($request->getPlaceId());
        if (empty($place)) {
            throw new PlaceNotFoundException();
        }
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