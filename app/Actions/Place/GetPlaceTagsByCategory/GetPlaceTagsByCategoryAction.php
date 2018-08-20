<?php

namespace Hedonist\Actions\Place\GetPlaceTagsByCategory;

use Hedonist\Repositories\Place\PlaceCategoryTagCriteria;
use Hedonist\Repositories\Place\PlaceCategoryTagRepository;

class GetPlaceTagsByCategoryAction
{
    private $categoryTagsRepository;

    public function __construct(PlaceCategoryTagRepository $repository)
    {
        $this->categoryTagsRepository = $repository;
    }

    public function execute(GetPlaceTagsByCategoryRequest $request): GetPlaceTagsByCategoryResponse
    {
        $tags = $this->categoryTagsRepository->findByCategory(
            $request->getCategoryId()
        );

        return new GetPlaceTagsByCategoryResponse($tags);
    }
}