<?php

namespace Hedonist\Actions\Place\GetUserRatingForPlace;

use Hedonist\Exceptions\Place\PlaceRatingNotFoundException;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetUserRatingForPlaceAction
{
    protected $repository;

    public function __construct(PlaceRatingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUserRatingForPlaceRequest $request): GetUserRatingForPlaceResponse
    {
        $userId = $request->getUserId();
        $userId = $userId ?: Auth::id();
        $placeId = $request->getPlaceId();

        $placeRating = $this->repository->getByPlaceUser($placeId, $userId);

        throw_if(
            $placeRating === null,
            new PlaceRatingNotFoundException('Item not found')
        );
        $response = new GetUserRatingForPlaceResponse(
            $placeRating->id,
            $placeRating->user_id,
            $placeRating->place_id,
            $placeRating->rating
        );
        return $response;
    }
}