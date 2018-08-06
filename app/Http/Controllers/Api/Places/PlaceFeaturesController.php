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
use Hedonist\Actions\Place\SpecialFeature\{
    CreatePlaceFeatureResponse,
    DeletePlaceFeatureResponse,
    ReadPlaceFeatureResponse,
    GetCollectionPlaceFeatureResponse
};
use Illuminate\Http\JsonResponse;

class PlaceFeaturesController extends ApiController
{
    private $createPlaceFeatureAction;
    private $deletePlaceFeatureAction;
    private $readPlaceFeatureAction;
    private $collectionPlaceFeatureAction;

    /**
     * PlaceFeaturesController constructor.
     * @param CreatePlaceFeatureAction $createPlaceFeatureAction
     * @param DeletePlaceFeatureAction $deletePlaceFeatureAction
     * @param ReadPlaceFeatureAction $readPlaceFeatureAction
     * @param GetCollectionPlaceFeatureAction $collectionPlaceFeatureAction
     */
    public function __construct(
        CreatePlaceFeatureAction $createPlaceFeatureAction,
        DeletePlaceFeatureAction $deletePlaceFeatureAction,
        ReadPlaceFeatureAction $readPlaceFeatureAction,
        GetCollectionPlaceFeatureAction $collectionPlaceFeatureAction
    )
    {
        $this->createPlaceFeatureAction = $createPlaceFeatureAction;
        $this->deletePlaceFeatureAction = $deletePlaceFeatureAction;
        $this->readPlaceFeatureAction = $readPlaceFeatureAction;
        $this->collectionPlaceFeatureAction = $collectionPlaceFeatureAction;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPlaceFeature() : JsonResponse
    {
        try {
            $response = $this->collectionPlaceFeatureAction->execute(
                new GetCollectionPlaceFeatureRequest()
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse($response->getCollection(), 201);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $httpRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function storePlaceFeature(CreateSpecialFeatureHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $response = $this->createPlaceFeatureAction->execute(
                new CreatePlaceFeatureRequest(
                    $httpRequest->name
                )
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse([
            'id' => $response->getId(),
            'name' => $response->getName()
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPlaceFeature($id) : JsonResponse
    {
        try {
            $response = $this->readPlaceFeatureAction->execute(
                new ReadPlaceFeatureRequest(
                    $id
                )
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse([
            'id' => $response->getId(),
            'name' => $response->getName()
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPlaceFeature($id) : JsonResponse
    {
        try {
            $response = $this->deletePlaceFeatureAction->execute(
                new DeletePlaceFeatureRequest(
                    $id
                )
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse([
            'id' => $response->getId(),
            'response' => $response->getResult()
        ], 201);
    }


}
