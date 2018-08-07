<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;


class SetPlaceRatingAction
{
    protected $repository;

    protected $placeRating;

    public function __construct(PlaceRatingRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->placeRating = null;
    }

    public function execute(SetPlaceRatingRequest $request): SetPlaceRatingResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $placeId = $request->getPlaceId();
        $ratingValue = $request->getRatingValue();

        if ($id) {
            $this->placeRating = $this->repository->getById($id);
        } else {
            $this->placeRating = $this->repository->getByPlaceUser($placeId,$userId);
        }

        if(!$this->placeRating) {
            $this->placeRating = new PlaceRating([
                'user_id' => $userId,
                'place_id' => $placeId,
                'rating' => $ratingValue
            ]);
        } else {
            $this->placeRating->rating = $ratingValue;
        }

        $this->placeRating = $this->repository->save($this->placeRating);

        $setPlaceRatingResponse = new SetPlaceRatingResponse(
            $this->placeRating->id,
            $this->placeRating->user_id,
            $this->placeRating->place_id,
            $this->placeRating->rating
        );

        return $setPlaceRatingResponse;
    }
}