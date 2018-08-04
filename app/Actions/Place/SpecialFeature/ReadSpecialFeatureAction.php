<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class ReadSpecialFeatureAction
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    public function execute(ReadSpecialFeatureRequest $request): ReadSpecialFeatureResponse
    {
        /** @var ReadSpecialFeatureRequest $request */
        $id = $request->getPlaceSpecialFeatureId();

        /** @var PlaceFeature $placeFeature */
        $placeFeature = $this->repository->getById($id);

        /** @var ReadSpecialFeatureResponse $response */
        $response = new ReadSpecialFeatureResponse(
            $placeFeature->id,
            $placeFeature->name
        );

        return $response;
    }


}