<?php

namespace Hedonist\Http\Controllers\Api\UserList;

use Hedonist\Actions\UserList\Places\{
    AttachPlaceAction,
    AttachPlaceRequest
};

class UserListPlaceController extends ApiController
{
    public $attachPlaceAction;

    public function __construct( AttachPlaceAction $attachPlaceAction) 
    {
        $this->attachPlaceAction = $attachPlaceAction;
    }

    public function attachPlace($id)
    {
        try {
            $response = $this->likePlaceAction->execute(
                new AttachPlaceRequest($id)
            );
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        }
        return $this->successResponse([], 200);                
    }
}
