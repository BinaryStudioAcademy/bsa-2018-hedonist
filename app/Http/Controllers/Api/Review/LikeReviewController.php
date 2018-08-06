<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Hedonist\Actions\Like\{LikeReviewAction,LikeReviewRequest};
use Hedonist\Http\Controllers\Api\ApiController;

class LikeReviewController extends ApiController
{
    private $likeReviewAction;

    public function __construct(LikeReviewAction $likeReviewAction)
    {
        $this->likeReviewAction = $likeReviewAction;
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