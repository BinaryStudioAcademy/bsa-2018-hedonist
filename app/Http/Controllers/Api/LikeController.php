<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Like\{DislikePlaceAction, DislikePlaceRequest, LikePlaceAction, LikePlaceRequest};

class LikeController extends ApiController
{
    private $likePlaceAction;
    private $dislikePlaceAction;

    public function __construct(LikePlaceAction $likePlaceAction, DislikePlaceAction $dislikePlaceAction)
    {
        $this->likePlaceAction = $likePlaceAction;
        $this->dislikePlaceAction = $dislikePlaceAction;
    }

    public function likePlace(int $id)
    {
        try {
            $request = new LikePlaceRequest($id);
            $response = $this->likePlaceAction->execute($request);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        return $this->successResponse('ok', 200);
    }

    public function dislikePlace(int $id)
    {
        try {
            $request = new DislikePlaceRequest($id);
            $response = $this->dislikePlaceAction->execute($request);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        return $this->successResponse('ok', 200);
    }
}