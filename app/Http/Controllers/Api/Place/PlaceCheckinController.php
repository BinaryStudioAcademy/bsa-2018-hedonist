<?php

namespace Hedonist\Http\Controllers\Api\Place;

use Hedonist\Actions\Place\Checkin\GetUserCheckInCollectionAction;
use Hedonist\Actions\Place\Checkin\GetUserCheckInCollectionPresenter;
use Hedonist\Actions\Place\Checkin\GetUserCheckInCollectionRequest;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\Place\Checkin\SetCheckinAction;
use Hedonist\Actions\Place\Checkin\SetCheckinRequest;
use Hedonist\Http\Requests\Place\Checkin\SetCheckinHttpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PlaceCheckinController extends ApiController
{
    private $setCheckinAction;
    private $getUserCheckInCollectionAction;
    private $checkInCollectionPresenter;

    public function __construct(
        SetCheckinAction $setCheckinAction,
        GetUserCheckInCollectionAction $getUserCheckInCollectionAction,
        GetUserCheckInCollectionPresenter $checkInCollectionPresenter
    ) {
        $this->setCheckinAction = $setCheckinAction;
        $this->getUserCheckInCollectionAction = $getUserCheckInCollectionAction;
        $this->checkInCollectionPresenter = $checkInCollectionPresenter;
    }
    
    public function setCheckin(SetCheckinHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $response = $this->setCheckinAction->execute(
                new SetCheckinRequest(
                    $httpRequest->place_id
                )
            );
        } catch (UserNotFoundException
                | PlaceNotFoundException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $response->getId(),
            'user_id' => $response->getUserId(),
            'place_id' => $response->getPlaceId()
        ], 201);
    }

    public function getUserCheckInCollection() : JsonResponse
    {
        $response = $this->getUserCheckInCollectionAction
            ->execute(new GetUserCheckInCollectionRequest(Auth::id()));

        return $this->successResponse($this->checkInCollectionPresenter->present($response));
    }
}