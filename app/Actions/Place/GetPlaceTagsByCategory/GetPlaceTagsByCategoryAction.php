<?php

namespace Hedonist\Actions\Place\GetPlaceTagsByCategory;

class GetPlaceTagsByCategoryAction
{
    private $categoryTagsRepository;

    public function __construct()
    {
    }

    public function execute(GetPlaceTagsByCategoryRequest $request): GetPlaceTagsByCategoryResponse
    {
        $tags = $this->categoryTagsRepository->getByCategoryId($request->getCategoryId());
        return new GetPlaceTagsByCategoryResponse($tags);
    }
}