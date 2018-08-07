<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\Place\SpecialFeature\Exceptions\PlaceFeatureNotFoundException;
use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class DeletePlaceFeatureAction
{
    protected $repository;

    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DeletePlaceFeatureRequest $request): DeletePlaceFeatureResponse
    {
        $id = $request->getPlaceFeatureId();

        $item = $this->repository->getById($id);
        if ($item) {
            $this->repository->deleteById($id);
        } else {
            throw new PlaceFeatureNotFoundException("Item #$id not found");
        }

        return new DeletePlaceFeatureResponse(
            $id,
            'deleted'
        );
    }
}