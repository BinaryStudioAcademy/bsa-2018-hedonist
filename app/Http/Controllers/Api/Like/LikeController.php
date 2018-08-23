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
            $this->likePlaceAction->execute(
                new LikePlaceRequest($id)
            );
            $placeResponse = $this->getLikedPlaceAction->execute(
                new GetLikedPlaceRequest($id)
            );
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }

        return $this->successResponse([
            'likes' => $placeResponse->getLikes(),
            'dislikes' => $placeResponse->getDislikes(),
            'likeStatus' => $placeResponse->getLikedStatus()
        ], 200);
    }

    public function getLikedPlace(int $id)
    {
        try {
            $response = $this->getLikedPlaceAction->execute(
                new GetLikedPlaceRequest($id)
            );
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        }

        return $this->successResponse([
            'likes' => $response->getLikes(),
            'dislikes' => $response->getDislikes(),
            'likeStatus' => $response->getLikedStatus()
        ], 200);
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
