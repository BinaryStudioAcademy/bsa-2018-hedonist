<?php

namespace Hedonist\Actions\Place\Rate;


use Hedonist\Repositories\Place\PlaceRateRepositoryInterface;
use Hedonist\Entities\Place\PlaceRate;


class SetRateAction
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
        $this->placeRate = null;
    }

    public function execute(SetRateRequest $request): SetRateResponse
    {
        $id = $request->getId();
        $userId = $request->getUserId();
        $placeId = $request->getPlaceId();
        $rateValue = $request->getRateValue();

        if ($id) {
            // TODO find object by 'id'
            $this->placeRate = $this->repository->getById($id);
        } else {
            // TODO find object by 'user_id' and 'place_id'
            $this->placeRate = $this->repository->getByUserAndPlace($userId, $placeId);
        }

        if(!$this->placeRate) {
            /** @var SetRateRequest $request */
            $value = $request->getRateValue();
            $placeRate = new PlaceRate([
                'user_id' => $userId,
                'place_id' => $rateValue,
                'rating' => $rateValue
            ]);
        }

        $placeRate = $this->repository->save($placeRate);

        /** @var  SetRateResponse $response */
        $response = $this->response = new SetRateResponse(
            $placeRate->id,
            $placeRate->user_id,
            $placeRate->place_id,
            $placeRate->value
        );

        return $response;

    }


}