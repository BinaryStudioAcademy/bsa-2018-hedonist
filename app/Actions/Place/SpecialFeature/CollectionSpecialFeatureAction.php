<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class CollectionSpecialFeatureAction
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    public function execute(CollectionSpecialFeatureRequest $request): CollectionSpecialFeatureResponse
    {
        /** @var ReadSpecialFeatureRequest $request */
        $id = $request->getPlaceSpecialFeatureId();

        /** @var PlaceFeature $placeFeature */
        $placeFeatures = $this->repository->findAll();

        /** @var CollectionSpecialFeatureResponse $response */
        $response = [];

        foreach ($placeFeatures as $placeFeature){
            /** @var ReadSpecialFeatureResponse $response */
            $response[] = new ReadSpecialFeatureResponse(
                $placeFeature->id,
                $placeFeature->name
            );
        }

        return $response;
    }


}