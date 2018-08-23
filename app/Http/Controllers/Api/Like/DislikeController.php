<?php

namespace Hedonist\Http\Controllers\Api\Like;

use Hedonist\Actions\Dislike\{
    DislikePlaceAction,
    DislikePlaceRequest,
    DislikeReviewAction,
    DislikeReviewRequest
};
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;

class DislikeController extends ApiController
{
    private $dislikePlaceAction;
    private $dislikeReviewAction;

    public function __construct(
        DislikePlaceAction $dislikePlaceAction,
        DislikeReviewAction $dislikeReviewAction
    ) {
        $this->dislikePlaceAction = $dislikePlaceAction;
        $this->dislikeReviewAction = $dislikeReviewAction;
    }

    public function dislikePlace(int $id)
    {
        try {
            $response = $this->dislikePlaceAction->execute(
                new DislikePlaceRequest($id)
            );
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        }

        return $this->successResponse([
            'likes' => $response->getLikes(),
            'dislikes' => $response->getDislikes()
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
