<?php

namespace Hedonist\Http\Controllers\Api\Place;

use Hedonist\Exceptions\DomainException;
use Hedonist\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Hedonist\Http\Requests\Place\Rate\{
    SetRatingHttpRequest,
    GetRatingHttpRequest
};
use Hedonist\Actions\Place\GetUserRatingForPlace\{
    GetUserRatingForPlaceAction,
    GetUserRatingForPlaceRequest
};
use Hedonist\Actions\Place\SetPlaceRating\{
    SetPlaceRatingAction,
    SetPlaceRatingRequest
};
use Hedonist\Actions\Place\GetPlaceRatingAverage\{
    GetPlaceRatingAvgRequest,
    GetPlaceRatingAvgAction
};

class PlaceRatingController extends ApiController
{
    private $getRatingAction;
    private $setRatingAction;
    private $getPlaceRatingAvgAction;

    public function __construct(
        GetUserRatingForPlaceAction $getRatingAction,
        SetPlaceRatingAction $setRatingAction,
        GetPlaceRatingAvgAction $getPlaceRateAvgAction
    ) {
        $this->getRatingAction = $getRatingAction;
        $this->setRatingAction = $setRatingAction;
        $this->getPlaceRatingAvgAction = $getPlaceRateAvgAction;
    }

    public function setRating(SetRatingHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $setPlaceRatingResponse = $this->setRatingAction->execute(
                new SetPlaceRatingRequest(
                    $httpRequest->rating,
                    $httpRequest->place_id
                )
            );
            $getPlaceRatingAvgResponse = $this->getPlaceRatingAvgAction->execute(
                new GetPlaceRatingAvgRequest(
                    $httpRequest->place_id
                )
            );
        } catch (DomainException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $setPlaceRatingResponse->getId(),
            'user_id' => $setPlaceRatingResponse->getUserId(),
            'place_id' => $setPlaceRatingResponse->getPlaceId(),
            'my_rating' => $setPlaceRatingResponse->getRatingValue(),
            'rating_avg' => $getPlaceRatingAvgResponse->getRatingAvgValue(),
            'rating_count' => $getPlaceRatingAvgResponse->getRatingVotesCount()
        ], 201);
    }

    public function getPlaceRatingAvg($placeId) : JsonResponse
    {
        try {
            $getPlaceMyRating = $this->getRatingAction->execute(
                new GetUserRatingForPlaceRequest(
                    $placeId
                )
            );
            $getPlaceRatingAvgResponse = $this->getPlaceRatingAvgAction->execute(
                new GetPlaceRatingAvgRequest(
                    $placeId
                )
            );
        } catch (DomainException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'place_id' => $getPlaceRatingAvgResponse->getPlaceId(),
            'rating_avg' => $getPlaceRatingAvgResponse->getRatingAvgValue(),
            'rating_count' => $getPlaceRatingAvgResponse->getRatingVotesCount(),
            'my_rating' => $getPlaceMyRating->getRatingValue()
        ], 201);
    }
}
