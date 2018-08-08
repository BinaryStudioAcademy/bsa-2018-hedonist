<?php

namespace Hedonist\Http\Controllers\Api\UserList;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\UserList\Places\{
    AttachPlaceAction,
    AttachPlaceRequest
};
use Hedonist\Http\Requests\UserList\AttachPlaceHttpRequest;
use Illuminate\Http\JsonResponse;

class UserListPlaceController extends ApiController
{
    public $attachPlaceAction;

    public function __construct(AttachPlaceAction $attachPlaceAction) 
    {
        $this->attachPlaceAction = $attachPlaceAction;
    }

    public function attachPlace(int $id, AttachPlaceHttpRequest $httpRequest): JsonResponse
    {
        try {
            $response = $this->attachPlaceAction->execute(
                new AttachPlaceRequest($id, $httpRequest->id)
            );
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
        return $this->successResponse([], 201);                
    }
}
