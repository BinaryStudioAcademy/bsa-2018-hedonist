<?php

namespace Hedonist\Actions\Dislike;

use Hedonist\Entities\Dislike\Dislike;
use Hedonist\Entities\Place\Place;
use Hedonist\Events\Dislike\DislikeAddEvent;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Repositories\Like\LikeRepository;
use Hedonist\Repositories\Dislike\DislikeRepository;
use Hedonist\Repositories\Place\PlaceRepository;
use Illuminate\Support\Facades\Auth;
use Hedonist\Entities\Like\LikeStatus;

class DislikePlaceAction
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

    public function execute(DislikePlaceRequest $request): DislikePlaceResponse
    {
        $place = $this->placeRepository->getById($request->getPlaceId());
        if ($place === null) {
            throw new PlaceNotFoundException();
        }

        $dislike = $this->dislikeRepository->findByUserAndPlace(Auth::id(), $request->getPlaceId());
        if ($dislike === null) {
            $dislike = new Dislike([
                'dislikeable_id' => $request->getPlaceId(),
                'dislikeable_type' => Place::class,
                'user_id' => Auth::id()
            ]);
            $this->dislikeRepository->save($dislike);
            event(new DislikeAddEvent($dislike));
        } else {
            $this->dislikeRepository->deleteById($dislike->id);
        }

        $place = $this->placeRepository->getByIdWithRelations($request->getPlaceId());
        if (!$place) {
            throw new PlaceNotFoundException;
        }

        $liked = LikeStatus::none();
        $userId = Auth::id();
        $like = $this->likeRepository->findByUserAndPlace($userId, $request->getPlaceId());
        if ($like) {
            $liked = LikeStatus::liked();
        } else {
            $dislike = $this->dislikeRepository->findByUserAndPlace($userId, $request->getPlaceId());
            if ($dislike) {
                $liked = LikeStatus::disliked();
            }
        }
        
        return new DislikePlaceResponse(
            $place->likes->count(),
            $place->dislikes->count(),
            $liked->value()
        );
    }
}
