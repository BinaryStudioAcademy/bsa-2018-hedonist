<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Place\SpecialFeature\CreateSpecialFeatureHttpRequest;

use Hedonist\Actions\Place\SpecialFeature\{
    CreatePlaceFeatureAction,
    DeletePlaceFeatureAction,
    ReadPlaceFeatureAction,
    GetCollectionPlaceFeatureAction
};
use Hedonist\Actions\Place\SpecialFeature\{
    CreatePlaceFeatureRequest,
    DeletePlaceFeatureRequest,
    ReadPlaceFeatureRequest,
    GetCollectionPlaceFeatureRequest
};

use Illuminate\Http\JsonResponse;

class PlaceFeaturesController extends ApiController
{
    private $createPlaceFeatureAction;
    private $deletePlaceFeatureAction;
    private $readPlaceFeatureAction;
    private $collectionPlaceFeatureAction;
    
    public function __construct(
        CreatePlaceFeatureAction $createPlaceFeatureAction,
        DeletePlaceFeatureAction $deletePlaceFeatureAction,
        ReadPlaceFeatureAction $readPlaceFeatureAction,
        GetCollectionPlaceFeatureAction $collectionPlaceFeatureAction
    ) {
        $this->createPlaceFeatureAction = $createPlaceFeatureAction;
        $this->deletePlaceFeatureAction = $deletePlaceFeatureAction;
        $this->readPlaceFeatureAction = $readPlaceFeatureAction;
        $this->collectionPlaceFeatureAction = $collectionPlaceFeatureAction;
    }
    
    public function indexPlaceFeature() : JsonResponse
    {
        try {
            $response = $this->collectionPlaceFeatureAction->execute(
                new GetCollectionPlaceFeatureRequest()
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }
        
        return $this->successResponse($response->getCollection(), 201);
    }
    
    public function storePlaceFeature(CreateSpecialFeatureHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $response = $this->createPlaceFeatureAction->execute(
                new CreatePlaceFeatureRequest(
                    $httpRequest->name
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $response->getId(),
            'name' => $response->getName()
        ], 201);
    }
    
    public function showPlaceFeature($id) : JsonResponse
    {
        try {
            $response = $this->readPlaceFeatureAction->execute(
                new ReadPlaceFeatureRequest(
                    $id
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $response->getId(),
            'name' => $response->getName()
        ], 201);
    }

    public function destroyPlaceFeature($id) : JsonResponse
    {
        try {
            $response = $this->deletePlaceFeatureAction->execute(
                new DeletePlaceFeatureRequest(
                    $id
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $response->getId(),
            'response' => $response->getResult()
        ], 201);
    }
}