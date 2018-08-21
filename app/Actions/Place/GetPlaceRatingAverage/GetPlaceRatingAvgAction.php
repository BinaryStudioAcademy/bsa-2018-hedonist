<?php

namespace Hedonist\Actions\Place\GetPlaceRatingAverage;

use Hedonist\Exceptions\Place\PlaceRatingNotFoundException;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;

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
        throw_if(
            $ratingAvg === null,
            new PlaceRatingNotFoundException('Item not found')
        );
        $ratingAvg = round($ratingAvg, 1);

        $ratingCount = $this->repository->getVotesCount($placeId);

        $response = new GetPlaceRatingAvgResponse(
            $placeId,
            $ratingAvg,
            $ratingCount
        );
        return $response;
    }
}