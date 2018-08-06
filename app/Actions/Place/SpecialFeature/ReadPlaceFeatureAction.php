<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class ReadPlaceFeatureAction
{
    protected $repository;

    /**
     * ReadPlaceFeatureAction constructor.
     * @param PlaceFeatureRepositoryInterface $repository
     */
    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function execute(ReadPlaceFeatureRequest $request): ReadPlaceFeatureResponse
    {
        $id = $request->getPlaceFeatureId();

        /** @var PlaceFeature $placeFeature */
        $placeFeature = $this->repository->getById($id);

        return new ReadPlaceFeatureResponse(
                    $placeFeature->id,
                    $placeFeature->name
                );
    }


}