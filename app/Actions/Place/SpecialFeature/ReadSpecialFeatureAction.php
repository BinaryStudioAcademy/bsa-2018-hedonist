<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;
use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class ReadSpecialFeatureAction implements ActionInterface
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    public function execute(RequestInterface $request): ResponseInterface
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