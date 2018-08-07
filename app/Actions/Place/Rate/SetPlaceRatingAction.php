<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;


class SetPlaceRatingAction
{
    /** @var PlaceRatingRepositoryInterface $repository */
    protected $repository;

    /** @var PlaceRating $placeRating */
    protected $placeRating;

    /**
     * SetPlaceRatingAction constructor.
     * @param PlaceRatingRepositoryInterface $repository
     */
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
            $ratingValue = $request->getRatingValue();
            $placeRating = new PlaceRating([
                'user_id' => $userId,
                'place_id' => $placeId,
                'rating' => $ratingValue
            ]);
        }

        $placeRating = $this->repository->save($placeRating);

        /** @var  SetPlaceRatingResponse $setPlaceRatingResponse */
        $setPlaceRatingResponse = new SetPlaceRatingResponse(
            $placeRating->id,
            $placeRating->user_id,
            $placeRating->place_id,
            $placeRating->value
        );

        return $setPlaceRatingResponse;

    }


}