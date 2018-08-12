<?php

namespace Hedonist\Actions\Place\Rate;

use Hedonist\Actions\Place\Rate\Exceptions\PlaceRatingMinMaxException;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;

class SetPlaceRatingAction
{
    protected $repository;
    protected $placeRepository;

    protected $placeRating;

    public function __construct(PlaceRatingRepositoryInterface $repository, PlaceRepositoryInterface $placeRepository)
    {
        $this->repository = $repository;
        $this->placeRepository = $placeRepository;

        $this->placeRating = null;
    }

    public function execute(SetPlaceRatingRequest $request): SetPlaceRatingResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $placeId = $request->getPlaceId();
        $ratingValue = $request->getRatingValue();

        throw_if(
            $ratingValue < 0 || $ratingValue > 10,
            new PlaceRatingMinMaxException('Rating value must be between 0 and 10')
        );

        if ($id) {
            $this->placeRating = $this->repository->getById($id);
        } else {
            $this->placeRating = $this->repository->getByPlaceUser($placeId, $userId);
        }

        throw_if(! $this->placeRepository->getById($placeId), new PlaceNotFoundException('Item not found'));

        if (! $this->placeRating) {
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