<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;

class ReadPlaceFeatureAction
{
    protected $repository;

    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ReadPlaceFeatureRequest $request): ReadPlaceFeatureResponse
    {
        $id = $request->getPlaceFeatureId();

        $placeFeature = $this->repository->getById($id);

        return new ReadPlaceFeatureResponse(
            $placeFeature->id,
            $placeFeature->name
        );
    }
}