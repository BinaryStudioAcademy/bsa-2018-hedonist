<?php

namespace Hedonist\Actions\Place\SavePlacePhoto;

use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Repositories\Place\PlaceCategoryRepositoryInterface;

class SavePlacePhotoAction
{
    private $placeCategoryRepository;

    public function __construct( $placeCategoryRepository)
    {
        $this->placeCategoryRepository = $placeCategoryRepository;
    }

    public function execute(SavePlaceCategoryRequest $request): SavePlaceCategoryResponse
    {
        $id = $request->getId();
        if ($id) {
            $placeCategory = $this->placeCategoryRepository->getById($id);
        } else {
            $placeCategory = new PlaceCategory;
        }
        $placeCategory->name = $request->getName();
        $placeCategory = $this->placeCategoryRepository->save($placeCategory);

        return new SavePlaceCategoryResponse($placeCategory);
    }
}