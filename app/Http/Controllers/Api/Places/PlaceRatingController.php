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
    private $getRatingAction;
    private $setRatingAction;
    private $getPlaceRatingAvgAction;
    private $userId;

    public function __construct(
        GetPlaceRatingAction $getRateAction,
        SetPlaceRatingAction $setRateAction,
        GetPlaceRatingAvgAction $getPlaceRateAvgAction
    )
    {
        $this->getRatingAction = $getRateAction;
        $this->setRatingAction = $setRateAction;
        $this->getPlaceRatingAvgAction = $getPlaceRateAvgAction;
        if (Auth::check()) {
            $this->userId = Auth::id();
        }
    }

    public function setRating(SetRatingHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $setPlaceRatingResponse = $this->setRatingAction->execute(
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
            'rating' => $setPlaceRatingResponse->getRatingValue()
        ], 201);
    }

    public function getRating(GetRatingHttpRequest $httpRequest, $id = null) : JsonResponse
    {
        try {
            $userId = $httpRequest->user_id ? $httpRequest->user_id : $this->userId;

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
            'rating' => $getPlaceRatingResponse->getRatingValue()
        ], 201);
    }

    public function getPlaceRatingAvg($placeId) : JsonResponse
    {
        try {
            $getPlaceRatingAvgResponse = $this->getPlaceRatingAvgAction->execute(
                new GetPlaceRatingAvgRequest(
                    $placeId
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'place_id' => $getPlaceRatingAvgResponse->getPlaceId(),
            'rating' => $getPlaceRatingAvgResponse->getRatingAvgValue()
        ], 201);
    }

}
