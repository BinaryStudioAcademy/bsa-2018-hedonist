<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;


class GetPlaceRatingAction
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
    }

    public function execute(GetPlaceRatingRequest $request): GetPlaceRatingResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $placeId = $request->getPlaceId();

        if ($id) {
            $this->placeRating = $this->repository->getById($id);
        } else {
            $this->placeRating = $this->repository->getByPlaceUser($placeId, $userId);
        }

        /** @var  GetPlaceRatingResponse $response */
        $response = $this->response = new SetPlaceRatingResponse(
            $this->placeRating->id,
            $this->placeRating->user_id,
            $this->placeRating->place_id,
            $this->placeRating->value
        );

        return $response;

    }


}