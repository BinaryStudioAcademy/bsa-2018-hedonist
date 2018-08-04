<?php

namespace Hedonist\Actions\Place\SpecialFeature;


use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;


class CreateSpecialFeatureAction
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    /**
     * CreateSpecialFeatureAction constructor.
     * @param PlaceFeatureRepositoryInterface $repository
     */
    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateSpecialFeatureRequest $request): CreateSpecialFeatureResponse
    {
        /** @var CreateSpecialFeatureRequest $request */
        $name = $request->getPlacesSpecialFeatureName();
        $placeFeature = new PlaceFeature([
            'name' => $name
        ]);
        $placeFeature = $this->repository->save($placeFeature);

        /** @var  CreateSpecialFeatureResponse $response */
        $response = $this->response = new CreateSpecialFeatureResponse(
            $placeFeature->id,
            $placeFeature->name
        );

        return $response;

    }


}