<?php

namespace Hedonist\Http\Controllers\Api\Place;

use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\Place\Checkin\SetCheckinAction;
use Hedonist\Actions\Place\Checkin\SetCheckinRequest;
use Hedonist\Http\Requests\Place\Checkin\SetCheckinHttpRequest;
use Illuminate\Http\JsonResponse;

class PlaceCheckinController extends ApiController
{
    private $setCheckinAction;

    public function __construct(SetCheckinAction $setCheckinAction)
    {
        $this->setCheckinAction = $setCheckinAction;
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
}