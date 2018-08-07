<?php

namespace Hedonist\Http\Controllers\Api\UserList;

use Hedonist\Actions\UserList\Places\{
    AttachPlaceAction,
    AttachPlaceRequest
};
use Hedonist\Http\Requests\UserList\AttachPlaceHttpRequest;

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
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 400);
        }
        return $this->successResponse([], 201);                
    }
}
