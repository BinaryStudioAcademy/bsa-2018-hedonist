<?php

namespace Hedonist\Http\Controllers\Api\Like;

use Hedonist\Actions\Like\{
    LikePlaceAction,
    LikePlaceRequest,
    LikePlaceResponse,
    GetLikedPlaceAction,
    GetLikedPlaceRequest,
    GetLikedPlaceResponse,
    LikeReviewAction,
    LikeReviewRequest
};
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;

class LikeController extends ApiController
{
    private $likePlaceAction;
    private $getLikedPlaceAction;
    private $likeReviewAction;

    public function __construct(
        LikePlaceAction $likePlaceAction,
        GetLikedPlaceAction $getLikedPlaceAction,
        LikeReviewAction $likeReviewAction
    ) {
        $this->likePlaceAction = $likePlaceAction;
        $this->getLikedPlaceAction = $getLikedPlaceAction;
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

        return $this->successResponse([
            'likes' => $response->getLikes(),
            'dislikes' => $response->getDislikes(),
            'status' => $response->getLikedStatus()
        ], 200);
    }

    public function getLikedPlace(int $id)
    {
        try {
            $getLikedPlaceResponse = $this->getLikedPlaceAction->execute(
                new GetLikedPlaceRequest($id)
            );
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        }

        return $this->successResponse(['liked' => $getLikedPlaceResponse->getLiked()], 200);
    }

    public function likeReview(int $id)
    {
        try {
            $response = $this->likeReviewAction->execute(
                new LikeReviewRequest($id)
            );
        } catch (ReviewNotFoundException $exception) {
            return $this->errorResponse('Review not found', 404);
        }
        
        return $this->successResponse([], 200);
    }
}
