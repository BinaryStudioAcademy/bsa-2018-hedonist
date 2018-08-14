<?php

namespace Hedonist\Actions\Place\GetPlaceCategoryCollection;

use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;

class GetPlaceCategoryCollectionAction
{
    private $placeCategoryRepository;

    public function __construct(PlaceCategoryRepositoryInterface $placeCategoryRepository)
    {
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(GetPlaceCategoryCollectionRequest $request): GetPlaceCategoryCollectionResponse
    {
        $placeCategories = $this->placeCategoryRepository->findAll();

        return new GetPlaceCategoryCollectionResponse($placeCategories);
    }
}