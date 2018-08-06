<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Like\{
    LikePlaceAction,
    LikePlaceRequest,
    LikeReviewAction,
    LikeReviewRequest
};
use Hedonist\Exceptions\Place\PlaceNotFoundException;

class LikeController extends ApiController
{
    private $likePlaceAction;
    private $likeReviewAction;

    public function __construct(
        LikePlaceAction $likePlaceAction,
        LikeReviewAction $likeReviewAction
    )
    {
        $this->likePlaceAction = $likePlaceAction;
        $this->likeReviewAction = $likeReviewAction;
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

    public function likeReview(int $id)
    {
        try {
            $response = $this->likeReviewAction->execute(
                new LikeReviewRequest($id)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        return $this->successResponse('ok', 200);
    }
}