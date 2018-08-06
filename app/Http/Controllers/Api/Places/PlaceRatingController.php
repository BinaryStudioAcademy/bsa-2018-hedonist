<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;

use Hedonist\Http\Requests\Place\Rate\{
    SetRatingHttpRequest,
    GetRatingHttpRequest
};

use Hedonist\Actions\Place\Rate\{
    GetPlaceRatingAction,
    SetPlaceRatingAction,
    GetPlaceRatingAvgAction
};

use Hedonist\Actions\Place\Rate\{
    GetPlaceRatingRequest,
    SetPlaceRatingRequest,
    GetPlaceRatingAvgRequest
};
use Illuminate\Support\Facades\Auth;

class PlaceRatingController extends ApiController
{
    private $getRateAction;
    private $setRateAction;
    private $getPlaceRateAvgAction;
    private $userId;

    public function __construct(
        GetPlaceRatingAction $getRateAction,
        SetPlaceRatingAction $setRateAction,
        GetPlaceRatingAvgAction $getPlaceRateAvgAction
    )
    {
        $this->getRateAction = $getRateAction;
        $this->setRateAction = $setRateAction;
        $this->getPlaceRateAvgAction = $getPlaceRateAvgAction;
        if (Auth::check()) {
            $this->userId = Auth::id();
        }
    }

    public function setRate(SetRatingHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $setPlaceRatingResponse = $this->setRateAction->execute(
                new SetPlaceRatingRequest(
                    $httpRequest->id,
                    $this->userId,
                    $httpRequest->placeId,
                    $httpRequest->rateValue
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $setPlaceRatingResponse->getId(),
            'user_id' => $setPlaceRatingResponse->getUserId(),
            'place_id' => $setPlaceRatingResponse->getPlaceId(),
            'rate' => $setPlaceRatingResponse->getRatingValue()
        ], 201);
    }

    public function getRate(GetRatingHttpRequest $httpRequest, $id = null) : JsonResponse
    {
        try {
            $userId = $httpRequest->userId ? $httpRequest->userId : $this->userId;

            $getPlaceRatingResponse = $this->getRateAction->execute(
                new GetPlaceRatingRequest(
                    $id,
                    $userId,
                    $httpRequest->placeId,
                    $httpRequest->rateValue
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $getPlaceRatingResponse->getId(),
            'user_id' => $getPlaceRatingResponse->getUserId(),
            'place_id' => $getPlaceRatingResponse->getPlaceId(),
            'rate' => $getPlaceRatingResponse->getRatingValue()
        ], 201);
    }

    public function getPlaceRateAvg($placeId) : JsonResponse
    {
        try {
            $getPlaceRatingAvgResponse = $this->getPlaceRateAvgAction->execute(
                new GetPlaceRatingAvgRequest(
                    $placeId
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'place_id' => $getPlaceRatingAvgResponse->getPlaceId(),
            'rate' => $getPlaceRatingAvgResponse->getRatingAvgValue()
        ], 201);
    }

}
