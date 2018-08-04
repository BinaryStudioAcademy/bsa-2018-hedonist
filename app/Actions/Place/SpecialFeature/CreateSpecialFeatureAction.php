<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;
use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;


class CreateSpecialFeatureAction implements ActionInterface
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

    public function execute(RequestInterface $request): ResponseInterface
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