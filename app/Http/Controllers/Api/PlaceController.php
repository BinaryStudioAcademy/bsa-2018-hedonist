<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Place\AddPlaceAction;
use Hedonist\Actions\Place\AddPlacePresenter;
use Hedonist\Actions\Place\AddPlaceRequest;
use Hedonist\Actions\Place\GetPlaceCollectionAction;
use Hedonist\Actions\Place\GetPlaceCollectionPresenter;
use Hedonist\Actions\Place\GetPlaceItemAction;
use Hedonist\Actions\Place\GetPlaceItemPresenter;
use Hedonist\Actions\Place\GetPlaceItemRequest;
use Hedonist\Actions\Place\RemovePlaceAction;
use Hedonist\Actions\Place\RemovePlaceRequest;
use Hedonist\Actions\Place\UpdatePlaceAction;
use Hedonist\Actions\Place\UpdatePlacePresenter;
use Hedonist\Actions\Place\UpdatePlaceRequest;
use Illuminate\Http\JsonResponse;

class PlaceController extends ApiController
{
    private $getPlaceCollectionAction;
    private $getPlaceItemAction;
    private $removePlaceAction;
    private $addPlaceAction;
    private $updatePlaceAction;

    public function __construct(
        GetPlaceItemAction $getPlaceItemAction,
        GetPlaceCollectionAction $getPlaceCollectionAction,
        RemovePlaceAction $removePlaceAction,
        AddPlaceAction $addPlaceAction,
        UpdatePlaceAction $updatePlaceAction
    ) {
        $this->getPlaceItemAction = $getPlaceItemAction;
        $this->getPlaceCollectionAction = $getPlaceCollectionAction;
        $this->removePlaceAction = $removePlaceAction;
        $this->addPlaceAction = $addPlaceAction;
        $this->updatePlaceAction = $updatePlaceAction;
    }

    public function getPlace(int $id): JsonResponse
    {
        try {
            $placeResponse = $this->getPlaceItemAction->execute(new GetPlaceItemRequest($id));
        } catch (\Exception $e) {
            return null;
        }

        return $this->successResponse(GetPlaceItemPresenter::present($placeResponse));
    }

    public function getCollection(): JsonResponse
    {
        try {
            $placeResponse = $this->getPlaceCollectionAction->execute();
        } catch (\Exception $e) {
            return null;
        }

        return $this->successResponse(GetPlaceCollectionPresenter::present($placeResponse));
    }

    public function removePlace(int $id): JsonResponse
    {
        try {
            $this->removePlaceAction->execute(new RemovePlaceRequest($id));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }

        return $this->successResponse(['message' => 'Place removed'], 201);
    }

    public function addPlace(\Hedonist\Http\Requests\Place\AddPlaceRequest $request): JsonResponse
    {
        try {
            $placeResponse = $this->addPlaceAction->execute(new AddPlaceRequest(
                $request->creator_id,
                $request->category_id,
                $request->city_id,
                $request->longitude,
                $request->latitude,
                $request->zip,
                $request->address
            ));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }

        return $this->successResponse(AddPlacePresenter::present($placeResponse));
    }

    public function updatePlace(\Hedonist\Http\Requests\Place\UpdatePlaceRequest $request): JsonResponse
    {
        try {
            $placeResponse = $this->updatePlaceAction->execute(new UpdatePlaceRequest(
                $request->id,
                $request->creator_id,
                $request->category_id,
                $request->city_id,
                $request->longitude,
                $request->latitude,
                $request->zip,
                $request->address
            ));
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }

        return $this->successResponse(UpdatePlacePresenter::present($placeResponse));
    }
}
