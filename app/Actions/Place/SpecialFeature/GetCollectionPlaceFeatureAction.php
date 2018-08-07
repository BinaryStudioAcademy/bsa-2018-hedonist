<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class GetCollectionPlaceFeatureAction
{
    protected $repository;

    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetCollectionPlaceFeatureRequest $request): GetCollectionPlaceFeatureResponse
    {
        $placeFeatures = $this->repository->findAll();

        $responseArray = [];

        foreach ($placeFeatures as $placeFeature) {
            $id = $placeFeature->id;
            $responseArray[$id] = [
                'id' => $id,
                'name' => $placeFeature->name,
            ];
        }
        return new GetCollectionPlaceFeatureResponse(
            $responseArray
        );
    }
}