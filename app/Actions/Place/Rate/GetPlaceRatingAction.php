<?php

namespace Hedonist\Actions\Place\Rate;

use Hedonist\Actions\Place\Rate\Exceptions\PlaceRatingNotFoundException;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;
use Illuminate\Support\Facades\Auth;

class GetPlaceRatingAction
{
    protected $repository;

    protected $placeRating;

    public function __construct(PlaceRatingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPlaceRatingRequest $request): GetPlaceRatingResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $userId = $userId ?: Auth::id();
        $placeId = $request->getPlaceId();

        if ($id) {
            $this->placeRating = $this->repository->getById($id);
        } else {
            $this->placeRating = $this->repository->getByPlaceUser($placeId, $userId);
        }

        throw_if(!$this->placeRating, new PlaceRatingNotFoundException('Item not found'));

        $response = $this->response = new GetPlaceRatingResponse(
            $this->placeRating->id,
            $this->placeRating->user_id,
            $this->placeRating->place_id,
            $this->placeRating->rating
        );

        return $response;
    }
}