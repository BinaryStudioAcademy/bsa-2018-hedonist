<?php

namespace Hedonist\Actions\Place\SetPlaceRating;

use Hedonist\Entities\Place\PlaceRating;
use Illuminate\Support\Facades\Auth;
use Hedonist\Exceptions\Place\{
    PlaceRatingMinMaxException,
    PlaceRatingNotFoundException,
    PlaceNotFoundException
};
use Hedonist\Repositories\Place\{
    PlaceRatingRepositoryInterface,
    PlaceRepositoryInterface
};

class SetPlaceRatingAction
{
    protected $repository;
    protected $placeRepository;

    public function __construct(PlaceRatingRepositoryInterface $repository, PlaceRepositoryInterface $placeRepository)
    {
        $this->repository = $repository;
        $this->placeRepository = $placeRepository;
    }

    public function execute(SetPlaceRatingRequest $request): SetPlaceRatingResponse
    {
        $userId = Auth::id();
        $placeId = $request->getPlaceId();
        $ratingValue = $request->getRatingValue();

        throw_if(
            $ratingValue < PlaceRating::MIN || $ratingValue > PlaceRating::MAX,
            new PlaceRatingMinMaxException('Rating value must be between '.PlaceRating::MIN.' and '.PlaceRating::MAX)
        );

        throw_if(
            !$this->placeRepository->getById($placeId),
            new PlaceNotFoundException('Item not found')
        );

        $placeRating = $this->repository->getByPlaceUser($placeId, $userId);

        if (!$placeRating) {
            $placeRating = new PlaceRating([
                'user_id' => $userId,
                'place_id' => $placeId,
                'rating' => $ratingValue
            ]);
        } else {
            $placeRating->rating = $ratingValue;
        }

        $placeRating = $this->repository->save($placeRating);

        $setPlaceRatingResponse = new SetPlaceRatingResponse(
            $placeRating->id,
            $placeRating->user_id,
            $placeRating->place_id,
            $placeRating->rating
        );
        
        return $setPlaceRatingResponse;
    }
}