<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Hedonist\Actions\Dislike\{DislikeReviewAction,DislikeReviewRequest};
use Hedonist\Http\Controllers\Api\ApiController;

class DislikeReviewController extends ApiController
{
    private $dislikeReviewAction;

    public function __construct(DislikeReviewAction $dislikeReviewAction)
    {
        $this->dislikeReviewAction = $dislikeReviewAction;
    }

    public function dislikeReview(int $id)
    {
        try {
            $response = $this->dislikeReviewAction->execute(
                new DislikeReviewRequest($id)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        return $this->successResponse('ok', 200);
    }
}