<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\User;
use Illuminate\Http\JsonResponse;

use Hedonist\Http\Requests\Place\Rate\{
    SetRateHttpRequest,
    GetRateHttpRequest
};

use Hedonist\Actions\Place\Rate\{
    GetRateAction,
    SetRateAction,
    GetPlaceRateAvgAction
};

use Hedonist\Actions\Place\Rate\{
    GetRateRequest,
    SetRateRequest,
    GetPlaceRateAvgRequest
};
use Hedonist\Actions\Place\Rate\{
    GetRateResponse,
    SetRateResponse,
    GetPlaceRateAvgResponse
};
use Illuminate\Support\Facades\Auth;

class RatesController extends ApiController
{
    /** @var GetRateAction **/
    private $getRateAction;
    /** @var SetRateAction **/
    private $setRateAction;
    /** @var GetPlaceRateAvgAction **/
    private $getPlaceRateAvgAction;
    /** @var int */
    private $userId;

    /**
     * RatesController constructor.
     * @param GetRateAction $getRateAction
     * @param SetRateAction $setRateAction
     * @param GetPlaceRateAvgAction $getPlaceRateAvgAction
     * @param SetRateHttpRequest $httpRequest
     */
    public function __construct(GetRateAction $getRateAction, SetRateAction $setRateAction, GetPlaceRateAvgAction $getPlaceRateAvgAction, SetRateHttpRequest $httpRequest)
    {
        $this->getRateAction = $getRateAction;
        $this->setRateAction = $setRateAction;
        $this->getPlaceRateAvgAction = $getPlaceRateAvgAction;
        if (Auth::check()) {
            $this->userId = Auth::id();
        } else {
            // TODO Remove user mock after authorization implementation
            $this->userId = User::all()->first();
        }
    }


    public function setRate(SetRateHttpRequest $httpRequest) : JsonResponse
    {
        try {
            /** @var SetRateResponse $response */
            $response = $this->setRateAction->execute(
                new SetRateRequest(
                    $httpRequest->id,
                    $this->userId,
                    $httpRequest->placeId,
                    $httpRequest->rateValue
                )
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse([
            'id' => $response->getId(),
            'user_id' => $response->getUserId(),
            'place_id' => $response->getPlaceId(),
            'rate' => $response->getRateValue()
        ], 201);
    }

    public function getRate(GetRateHttpRequest $httpRequest, $id = null) : JsonResponse
    {
        try {
            $userId = $httpRequest->userId ? $httpRequest->userId : $this->userId;

            /** @var SetRateResponse $response */
            $response = $this->setRateAction->execute(
                new SetRateRequest(
                    $id,
                    $userId,
                    $httpRequest->placeId,
                    $httpRequest->rateValue
                )
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse([
            'id' => $response->getId(),
            'user_id' => $response->getUserId(),
            'place_id' => $response->getPlaceId(),
            'rate' => $response->getRateValue()
        ], 201);
    }

    public function getPlaceRateAvg($placeId) : JsonResponse
    {
        try {
            /** @var GetPlaceRateAvgResponse $response */
            $response = $this->getPlaceRateAvgAction->execute(
                new GetPlaceRateAvgRequest(
                    $placeId
                )
            );
        } catch (\Exception $ex) {
            // base api controller
            return $this->errorResponse($ex->getMessage(), 400);
        }

        // base api controller
        return $this->successResponse([
            'place_id' => $response->getPlaceId(),
            'rate' => $response->getRateAvgValue()
        ], 201);
    }

}
