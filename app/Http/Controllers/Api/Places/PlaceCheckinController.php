<?php

namespace Hedonist\Http\Controllers\Api\Places;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\Place\Checkin\SetCheckinAction;
use Hedonist\Actions\Place\Checkin\SetCheckinRequest;
use Hedonist\Http\Requests\Place\Checkin\SetCheckinHttpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PlaceCheckinController extends ApiController
{
    private $setCheckinAction;
    private $userId;

    public function __construct(SetCheckinAction $setCheckinAction )
    {
        $this->setCheckinAction = $setCheckinAction;
        if (Auth::check()) {
            $this->userId = Auth::id();
        }
    }
    
    public function setCheckin(SetCheckinHttpRequest $httpRequest) : JsonResponse
    {
        try {
            $response = $this->setCheckinAction->execute(
                new SetCheckinRequest(
                    $this->userId,
                    $httpRequest->place_id
                )
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'id' => $response->getId(),
            'user_id' => $response->getUserId(),
            'place_id' => $response->getPlaceId()
        ], 201);
    }
}