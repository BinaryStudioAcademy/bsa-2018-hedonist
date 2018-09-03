<?php

namespace Hedonist\Actions\Place\GetPlaceTagsByCategory;

use Hedonist\Repositories\Place\TagRepository;

class GetPlaceTagsByCategoryAction
{
    private $categoryTagsRepository;

    public function __construct(TagRepository $repository)
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