<?php

namespace Hedonist\Actions\Place\SpecialFeature;


use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;


class CreatePlaceFeatureAction
{
    protected $repository;

    /**
     * CreatePlaceFeatureAction constructor.
     * @param PlaceFeatureRepositoryInterface $repository
     */
    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreatePlaceFeatureRequest $request): CreatePlaceFeatureResponse
    {
        $name = $request->getPlaceFeatureName();
        $placeFeature = new PlaceFeature([
            'name' => $name
        ]);
        $placeFeature = $this->repository->save($placeFeature);

        return new CreatePlaceFeatureResponse(
                        $placeFeature->id,
                        $placeFeature->name
                    );
    }


}