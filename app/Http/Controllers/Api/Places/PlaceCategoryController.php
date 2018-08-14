<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Actions\Place\GetPlaceCategoryCollection\GetPlaceCategoryCollectionAction;
use Hedonist\Actions\Place\GetPlaceCategoryCollection\GetPlaceCategoryCollectionRequest;
use Hedonist\Actions\Place\GetPlaceCategoryItem\GetPlaceCategoryItemAction;
use Hedonist\Actions\Place\GetPlaceCategoryItem\GetPlaceCategoryItemRequest;
use Hedonist\Actions\Place\RemovePlaceCategory\RemovePlaceCategoryAction;
use Hedonist\Actions\Place\RemovePlaceCategory\RemovePlaceCategoryRequest;
use Hedonist\Actions\Place\SaveCategory\SavePlaceCategoryAction;
use Hedonist\Actions\Place\SaveCategory\SavePlaceCategoryRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Place\PlaceCategoryRequest;
use Illuminate\Http\JsonResponse;

class PlaceCategoryController extends ApiController
{
    private $savePlaceCategoryAction;
    private $getPlaceCategoryCollectionAction;
    private $getPlaceCategoryItemAction;
    private $removePlaceCategoryAction;

    public function __construct(
        SavePlaceCategoryAction $savePlaceCategoryAction,
        GetPlaceCategoryCollectionAction $getPlaceCategoryCollectionAction,
        GetPlaceCategoryItemAction $getPlaceCategoryItemAction,
        RemovePlaceCategoryAction $removePlaceCategoryAction
    ) {
        $this->savePlaceCategoryAction = $savePlaceCategoryAction;
        $this->getPlaceCategoryCollectionAction = $getPlaceCategoryCollectionAction;
        $this->getPlaceCategoryItemAction = $getPlaceCategoryItemAction;
        $this->removePlaceCategoryAction = $removePlaceCategoryAction;
    }

    public function index(): JsonResponse
    {
        $responsePlaceCategory = $this->getPlaceCategoryCollectionAction->execute(new GetPlaceCategoryCollectionRequest());

        return $this->successResponse($responsePlaceCategory->toArray(), 200);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $responsePlaceCategory = $this->getPlaceCategoryItemAction->execute(
                new GetPlaceCategoryItemRequest($id)
            );

            return $this->successResponse($responsePlaceCategory->toArray(), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
    }

    public function store(PlaceCategoryRequest $request): JsonResponse
    {
        try {
            $responsePlaceCategory = $this->savePlaceCategoryAction->execute(
                new SavePlaceCategoryRequest(
                    $request->get('name')
                )
            );

            return $this->successResponse($responsePlaceCategory->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function update(PlaceCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $responsePlaceCategory = $this->savePlaceCategoryAction->execute(
                new SavePlaceCategoryRequest(
                    $request->get('name'),
                    $id
                )
            );

            return $this->successResponse($responsePlaceCategory->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->removePlaceCategoryAction->execute(new RemovePlaceCategoryRequest($id));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}