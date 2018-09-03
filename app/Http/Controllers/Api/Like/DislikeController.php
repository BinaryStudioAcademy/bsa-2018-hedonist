<?php

namespace Hedonist\Http\Controllers\Api\Like;

use Hedonist\Actions\Dislike\{
    DislikePlaceAction,
    DislikePlaceRequest,
    DislikeReviewAction,
    DislikeReviewRequest
};
use Hedonist\Actions\Like\{
    GetLikedPlaceAction,
    GetLikedPlaceRequest,
    GetLikedPlaceResponse
};
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Exceptions\DomainException;
use Hedonist\Http\Controllers\Api\ApiController;

class DislikeController extends ApiController
{
    private $dislikePlaceAction;
    private $getLikedPlaceAction;
    private $dislikeReviewAction;

    public function __construct(
        DislikePlaceAction $dislikePlaceAction,
        GetLikedPlaceAction $getLikedPlaceAction,
        DislikeReviewAction $dislikeReviewAction
    ) {
        $this->dislikePlaceAction = $dislikePlaceAction;
        $this->getLikedPlaceAction = $getLikedPlaceAction;
        $this->dislikeReviewAction = $dislikeReviewAction;
    }

    public function dislikePlace(int $id)
    {
        try {
            $this->dislikePlaceAction->execute(
                new DislikePlaceRequest($id)
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

    public function dislikeReview(int $id)
    {
        try {
            $response = $this->dislikeReviewAction->execute(
                new DislikeReviewRequest($id)
            );
        } catch (ReviewNotFoundException $exception) {
            return $this->errorResponse('Review not found', 404);
        }

        return $this->successResponse([], 200);
    }
}
