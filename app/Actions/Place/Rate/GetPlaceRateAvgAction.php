<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRateRepositoryInterface;
use Hedonist\Entities\Place\PlaceRate;


class GetPlaceRateAvgAction
{
    /** @var PlaceRateRepositoryInterface $repository */
    protected $repository;

    /**
     * SetRateAction constructor.
     * @param PlaceRateRepositoryInterface $repository
     */
    public function __construct(PlaceRateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetPlaceRateAvgRequest $request): GetPlaceRateAvgResponse
    {

        $placeId = $request->getPlaceId();

        // TODO find object 'place_id'
        $rateAvg = $this->placeRate = $this->repository->getPlaceRateAvg($placeId);

        /** @var  GetPlaceRateAvgResponse $response */
        $response = $this->response = new GetPlaceRateAvgResponse(
            $placeId,
            $rateAvg
        );

        return $response;

    }


}