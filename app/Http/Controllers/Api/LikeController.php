<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Like\{
    LikePlaceAction,
    LikePlaceRequest
};

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
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        return $this->successResponse('ok', 200);
    }
}