<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class DeleteSpecialFeatureAction
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    public function execute(DeleteSpecialFeatureRequest $request): DeleteSpecialFeatureResponse
    {
        /** @var DeleteSpecialFeatureRequest $request */
        $id = $request->getPlaceSpecialFeatureId();

        $this->repository->deleteById($id);

        /** @var DeleteSpecialFeatureResponse $response */
        $response = new DeleteSpecialFeatureResponse(
            $id
        );

        return $response;
    }


}