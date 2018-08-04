<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class CollectionSpecialFeatureAction
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    /**
     * CollectionSpecialFeatureAction constructor.
     * @param PlaceFeatureRepositoryInterface $repository
     */
    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CollectionSpecialFeatureRequest $request): CollectionSpecialFeatureResponse
    {
        /** @var PlaceFeature $placeFeature */
        $placeFeatures = $this->repository->findAll();

//        print_r($placeFeatures->toArray());
//        die;

        /** @var CollectionSpecialFeatureResponse $response */
        $responseArray = [];

        foreach ($placeFeatures as $placeFeature){
            /** @var ReadSpecialFeatureResponse $response */
            $responseArray[] = new ReadSpecialFeatureResponse(
                $placeFeature->id,
                $placeFeature->name
            );
        }

//        print_r($responseArray);
//        die;

        $response = new CollectionSpecialFeatureResponse($responseArray);

        return $response;
    }


}