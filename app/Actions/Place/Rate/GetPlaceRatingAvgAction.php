<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Actions\Place\Rate\Exceptions\PlaceRatingNotFoundException;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Hedonist\Entities\Place\PlaceRating;


class GetPlaceRatingAvgAction
{
    protected $repository;

    public function __construct(PlaceRatingRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPlaceRatingAvgRequest $request): GetPlaceRatingAvgResponse
    {
        $placeId = $request->getPlaceId();

        $ratingAvg = $this->repository->getAverage($placeId);
        throw_if(!$ratingAvg, new PlaceRatingNotFoundException('Item not found'));
        $ratingAvg = round($ratingAvg,1);

        $response = $this->response = new GetPlaceRatingAvgResponse(
            $placeId,
            $ratingAvg
        );
        return $response;
    }
}