<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Entities\User\User;
use Illuminate\Http\JsonResponse;

use Hedonist\Http\Requests\Place\Rate\{
    SetRateHttpRequest,
    GetRateHttpRequest
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
use Hedonist\Actions\Place\Rate\{
    GetPlaceRatingResponse,
    SetPlaceRatingResponse,
    GetPlaceRatingAvgResponse
};
use Illuminate\Support\Facades\Auth;

class PlaceRatingController extends ApiController
{
    /** @var GetPlaceRatingAction **/
    private $getRateAction;
    /** @var SetPlaceRatingAction **/
    private $setRateAction;
    /** @var GetPlaceRatingAvgAction **/
    private $getPlaceRateAvgAction;
    /** @var int */
    private $userId;

    /**
     * PlaceRatingController constructor.
     * @param GetPlaceRatingAction $getRateAction
     * @param SetPlaceRatingAction $setRateAction
     * @param GetPlaceRatingAvgAction $getPlaceRateAvgAction
     * @param SetRateHttpRequest $httpRequest
     */
    public function __construct(GetPlaceRatingAction $getRateAction, SetPlaceRatingAction $setRateAction, GetPlaceRatingAvgAction $getPlaceRateAvgAction, SetRateHttpRequest $httpRequest)
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
            /** @var SetPlaceRatingResponse $response */
            $response = $this->setRateAction->execute(
                new SetPlaceRatingRequest(
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
            'rate' => $response->getRatingValue()
        ], 201);
    }

    public function getRate(GetRateHttpRequest $httpRequest, $id = null) : JsonResponse
    {
        try {
            $userId = $httpRequest->userId ? $httpRequest->userId : $this->userId;

            /** @var GetPlaceRatingResponse $response */
            $response = $this->getRateAction->execute(
                new GetPlaceRatingRequest(
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
            'rate' => $response->getRatingValue()
        ], 201);
    }

    public function getPlaceRateAvg($placeId) : JsonResponse
    {
        try {
            /** @var GetPlaceRatingAvgResponse $response */
            $response = $this->getPlaceRateAvgAction->execute(
                new GetPlaceRatingAvgRequest(
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
            'rate' => $response->getRatingAvgValue()
        ], 201);
    }

}
