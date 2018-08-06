<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Place\PlaceRepository;
use Illuminate\Support\Facades\Auth;

class DislikePlaceAction
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

    public function execute(DislikePlaceRequest $request): DislikePlaceResponse
    {
        $place = $this->placeRepository->getById($request->getPlaceId());
        if (empty($place)) {
            throw new PlaceNotFoundException();
        }
        $like = $this->likeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        $dislike = $this->dislikeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        if ($like) {
            $this->likeRepository->deleteById($like->id);
        }
        if (empty($dislike)) {
            $dislike = new Dislike([
                'dislikeable_id' => $request->getPlaceId(),
                'dislikeable_type' => Place::class,
                'user_id' => Auth::id()
            ]);
            $this->dislikeRepository->save($dislike);
        }

        return new DislikePlaceResponse();
    }
}