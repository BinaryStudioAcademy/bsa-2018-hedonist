<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;
use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class DeleteSpecialFeatureAction implements ActionInterface
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    public function execute(RequestInterface $request): ResponseInterface
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