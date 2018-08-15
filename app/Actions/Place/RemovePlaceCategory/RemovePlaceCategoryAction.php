<?php

namespace Hedonist\Actions\Place\RemovePlaceCategory;

use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;

class RemovePlaceCategoryAction
{
    private $placeCategoryRepository;

    public function __construct(PlaceCategoryRepositoryInterface $placeCategoryRepository)
    {
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(RemovePlaceCategoryRequest $request): void
    {
        $this->placeCategoryRepository->deleteById($request->getId());
    }
}