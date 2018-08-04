<?php

namespace Hedonist\Actions\Place\SpecialFeature;

use Hedonist\Repositories\Place\PlaceFeatureRepositoryInterface;
use Hedonist\Entities\Place\PlaceFeature;

class DeleteSpecialFeatureAction
{
    /** @var PlaceFeatureRepositoryInterface $repository */
    protected $repository;

    /**
     * DeleteSpecialFeatureAction constructor.
     * @param PlaceFeatureRepositoryInterface $repository
     */
    public function __construct(PlaceFeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(DeleteSpecialFeatureRequest $request): DeleteSpecialFeatureResponse
    {
        /** @var DeleteSpecialFeatureRequest $request */
        $id = $request->getPlaceSpecialFeatureId();

        $item = $this->repository->getById($id);
        if ($item) {
            $this->repository->deleteById($id);
        } else {
            throw new \Exception("Item #$id not found");
        }

        /** @var DeleteSpecialFeatureResponse $response */
        $response = new DeleteSpecialFeatureResponse(
            $id,
            'deleted'
        );

        return $response;
    }


}