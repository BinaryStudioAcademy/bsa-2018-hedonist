<?php

namespace Hedonist\Actions\Place\GetPlaceRating;

use Hedonist\Exceptions\Place\PlaceRatingNotFoundException;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetPlaceRatingAction
{
    protected $repository;

    public function __construct(PlaceRatingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPlaceRatingRequest $request): GetPlaceRatingResponse
    {
        $userId = $request->getUserId();
        $userId = $userId ?: Auth::id();
        $placeId = $request->getPlaceId();

        $placeRating = $this->repository->getByPlaceUser($placeId, $userId);

        throw_if(
            $placeRating === null,
            new PlaceRatingNotFoundException('Item not found')
        );
        $response = new GetPlaceRatingResponse(
            $placeRating->id,
            $placeRating->user_id,
            $placeRating->place_id,
            $placeRating->rating
        );
        return $response;
    }
}