<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Like\{
    LikePlaceAction,
    LikePlaceRequest
};
use Hedonist\Exceptions\Place\PlaceNotFoundException;

class LikeController extends ApiController
{
    private $likePlaceAction;

    public function __construct(LikePlaceAction $likePlaceAction)
    {
        $this->likePlaceAction = $likePlaceAction;
    }

    public function likePlace(int $id)
    {
        try {
            $response = $this->likePlaceAction->execute(
                new LikePlaceRequest($id)
            );
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        }
        return $this->successResponse([], 200);
    }
}