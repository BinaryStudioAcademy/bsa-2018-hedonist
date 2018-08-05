<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRateRepositoryInterface;
use Hedonist\Entities\Place\PlaceRate;


class GetRateAction
{
    /** @var PlaceRateRepositoryInterface $repository */
    protected $repository;

    /** @var PlaceRate $placeRate */
    protected $placeRate;

    /**
     * SetRateAction constructor.
     * @param PlaceRateRepositoryInterface $repository
     */
    public function __construct(PlaceRateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetRateRequest $request): GetRateResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $placeId = $request->getPlaceId();

        if ($id) {
            // TODO find object by 'id'
            $this->placeRate = $this->repository->getById($id);
        } else {
            // TODO find object by 'user_id' and 'place_id'
            $this->placeRate = $this->repository->getByUserAndPlace($userId, $placeId);
        }

        /** @var  GetRateResponse $response */
        $response = $this->response = new SetRateResponse(
            $this->placeRate->id,
            $this->placeRate->user_id,
            $this->placeRate->place_id,
            $this->placeRate->value
        );

        return $response;

    }


}