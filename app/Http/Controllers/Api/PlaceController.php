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
use Hedonist\Exceptions\PlaceExceptions\AbstractPlaceException;
use Hedonist\Http\Requests\Place\ValidateAddPlaceRequest;
use Hedonist\Http\Requests\Place\ValidateUpdatePlaceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

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
        } catch (AbstractPlaceException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse(GetPlaceItemPresenter::present($placeResponse));
    }

    public function getCollection(): JsonResponse
    {
        try {
            $placeResponse = $this->getPlaceCollectionAction->execute();
        } catch (AbstractPlaceException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse(GetPlaceCollectionPresenter::present($placeResponse));
    }

    public function removePlace(int $id)
    {
        try {
            $this->removePlaceAction->execute(new RemovePlaceRequest($id));
        } catch (AbstractPlaceException $e) {
            return Response::make(null, 404);
        }

        return Response::make(null, 204); // TODO how to make response without content
    }

    public function addPlace(ValidateAddPlaceRequest $request): JsonResponse
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
        } catch (AbstractPlaceException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse(AddPlacePresenter::present($placeResponse), 201);
    }

    public function updatePlace(ValidateUpdatePlaceRequest $request): JsonResponse
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
        } catch (AbstractPlaceException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse(UpdatePlacePresenter::present($placeResponse), 201);
    }
}
