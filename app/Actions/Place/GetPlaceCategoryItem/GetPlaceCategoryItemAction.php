<?php

namespace Hedonist\Actions\Place\GetPlaceCategoryItem;

use Hedonist\Exceptions\Place\PlaceCategoryDoesNotExistException;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;

class GetPlaceCategoryItemAction
{
    private $placeCategoryRepository;

    public function __construct(PlaceCategoryRepositoryInterface $placeCategoryRepository)
    {
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(GetPlaceCategoryItemRequest $request): GetPlaceCategoryItemResponse
    {
        $placeCategory = $this->placeCategoryRepository->getById($request->getId());
        if (!$placeCategory) {
            throw new PlaceCategoryDoesNotExistException();
        }

        return new GetPlaceCategoryItemResponse($placeCategory);
    }
}