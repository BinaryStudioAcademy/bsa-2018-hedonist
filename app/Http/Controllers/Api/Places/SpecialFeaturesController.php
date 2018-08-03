<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Hedonist\Http\Controllers\Controller;
use Hedonist\Actions\Place\SpecialFeature\{
    CreateSpecialFeatureAction,
    DeleteSpecialFeatureAction,
    ReadSpecialFeatureAction,
    CollectionSpecialFeatureAction
};
use Hedonist\Actions\Place\SpecialFeature\{
    CreateSpecialFeatureRequest,
    DeleteSpecialFeatureRequest,
    ReadSpecialFeatureRequest,
    CollectionSpecialFeatureRequest
};
use Hedonist\Actions\Place\SpecialFeature\{
    CreateSpecialFeatureResponse,
    DeleteSpecialFeatureResponse,
    ReadSpecialFeatureResponse,
    CollectionSpecialFeatureResponse
};

class SpecialFeaturesController extends ApiController
{
    /** @var CreateSpecialFeatureAction **/
    protected $createSpecialFeatureAction;
    /** @var DeleteSpecialFeatureAction **/
    protected $deleteSpecialFeatureAction;
    /** @var ReadSpecialFeatureAction **/
    protected $readSpecialFeatureAction;
    /** @var CollectionSpecialFeatureAction **/
    protected $collectionSpecialFeatureAction;

    /**
     * SpecialFeaturesController constructor.
     * @param CreateSpecialFeatureAction $createSpecialFeatureAction
     * @param DeleteSpecialFeatureAction $deleteSpecialFeatureAction
     * @param ReadSpecialFeatureAction $readSpecialFeatureAction
     * @param CollectionSpecialFeatureAction $collectionSpecialFeatureAction
     */
    public function __construct(
        CreateSpecialFeatureAction $createSpecialFeatureAction,
        DeleteSpecialFeatureAction $deleteSpecialFeatureAction,
        ReadSpecialFeatureAction $readSpecialFeatureAction,
        CollectionSpecialFeatureAction $collectionSpecialFeatureAction
    )
    {
        $this->createSpecialFeatureAction = $createSpecialFeatureAction;
        $this->deleteSpecialFeatureAction = $deleteSpecialFeatureAction;
        $this->readSpecialFeatureAction = $readSpecialFeatureAction;
        $this->collectionSpecialFeatureAction = $collectionSpecialFeatureAction;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            /** @var CollectionSpecialFeatureResponse $response */
            $response = $this->collectionSpecialFeatureAction->execute(
                new CollectionSpecialFeatureRequest()
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
    public function store(Request $httpRequest)
    {
        try {
            /** @var CreateSpecialFeatureResponse $response */
            $response = $this->readSpecialFeatureAction->execute(
                new CreateSpecialFeatureRequest(
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
    public function show($id)
    {
        try {
            /** @var ReadSpecialFeatureResponse $response */
            $response = $this->readSpecialFeatureAction->execute(
                new ReadSpecialFeatureRequest(
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
    public function destroy($id)
    {
        try {
            /** @var DeleteSpecialFeatureResponse $response */
            $response = $this->readSpecialFeatureAction->execute(
                new DeleteSpecialFeatureRequest(
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
        ], 201);
    }


}
