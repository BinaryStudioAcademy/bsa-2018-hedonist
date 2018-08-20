<?php

namespace Hedonist\Http\Controllers\Api\Place;

use Illuminate\Http\JsonResponse;
use Hedonist\Http\Controllers\Api\ApiController;

use Hedonist\Actions\Place\GetPlaceTagsByCategory\GetPlaceTagsByCategoryAction;
use Hedonist\Actions\Place\GetPlaceTagsByCategory\GetPlaceTagsByCategoryRequest;

class PlaceCategoryTagsController extends ApiController
{
    private $getPlaceTagsByCategoryAction;

    public function __construct(GetPlaceTagsByCategoryAction $getPlaceTagsByCategoryAction)
    {
        $this->getPlaceTagsByCategoryAction = $getPlaceTagsByCategoryAction;
    }

    public function getTagsByCategoryId(int $id): JsonResponse
    {
        $getPlaceTagsByCategoryResponse = $this->getPlaceTagsByCategoryAction->execute(
            new GetPlaceTagsByCategoryRequest($id)
        );
        return $this->successResponse($getPlaceTagsByCategoryResponse->getTags());
    }
}
