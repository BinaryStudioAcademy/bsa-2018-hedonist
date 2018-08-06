<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;


class GetPlaceRatingAvgAction
{
    /** @var PlaceRatingRepositoryInterface $repository */
    protected $repository;

    /**
     * SetPlaceRatingAction constructor.
     * @param PlaceRatingRepositoryInterface $repository
     */
    public function __construct(PlaceRatingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPlaceRatingAvgRequest $request): GetPlaceRatingAvgResponse
    {

        $placeId = $request->getPlaceId();

        // TODO find object 'place_id'
        $ratingAvg = $this->placeRating = $this->repository->getAverage($placeId);

        /** @var  GetPlaceRatingAvgResponse $response */
        $response = $this->response = new GetPlaceRatingAvgResponse(
            $placeId,
            $ratingAvg
        );

        return $response;

    }


}