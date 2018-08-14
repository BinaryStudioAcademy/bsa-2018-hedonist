<?php

namespace Hedonist\Actions\Place\GetPlaceCategoryByName;

use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;

class GetPlaceCategoryByNameAction
{
    private $placeCategoryRepository;

    public function __construct(PlaceCategoryRepositoryInterface $placeCategoryRepository)
    {
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(GetPlaceCategoryByNameRequest $request): GetPlaceCategoryByNameResponse
    {
        $placeCategories = $this->placeCategoryRepository->getByName($request->getName(), $request->getLimit());

        return new GetPlaceCategoryByNameResponse($placeCategories);
    }
}