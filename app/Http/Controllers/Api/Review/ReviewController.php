<?php

namespace Hedonist\Http\Controllers;

use Hedonist\Actions\Review\{
    GetReviewAction,
    UpdateReviewDescriptionAction,
    CreateReviewAction,
    DeleteReviewAction,
    GetReviewCollectionAction
};
use Hedonist\Actions\Review\{
    GetReviewRequest,
    CreateReviewRequest,
    DeleteReviewRequest,
    UpdateReviewDescriptionRequest
};
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Review\SaveReviewRequest;
use Hedonist\Exceptions\Review\ReviewNotFoundException;

class ReviewController extends ApiController
{
    private $getReviewAction;
    private $updateReviewAction;
    private $createReviewAction;
    private $deleteReviewAction;
    private $getReviewCollectionAction;

    public function __construct(
        GetReviewAction $getReviewAction,
        CreateReviewAction $createReviewAction,
        DeleteReviewAction $deleteReviewAction,
        UpdateReviewDescriptionAction $updateReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction
    ) {
        $this->getReviewAction = $getReviewAction;
        $this->updateReviewAction = $updateReviewAction;
        $this->createReviewAction = $createReviewAction;
        $this->deleteReviewAction = $deleteReviewAction;
        $this->getReviewCollectionAction = $getReviewCollectionAction;
    }

    public function getReview(int $id)
    {
        try {
            $getReviewResponse = $this->getReviewAction->execute(
                new GetReviewRequest($id)
            );
            return $this->successResponse($getReviewResponse->getModel()->toArray());
        } catch (ReviewNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function getReviewCollection()
    {
        $getReviewCollectionResponse = $this->getReviewCollectionAction->execute();
        return $this->successResponse($getReviewCollectionResponse->getReviewCollection());
    }

    public function createReview(SaveReviewRequest $request)
    {
        try {
            $createReviewResponse = $this->createReviewAction->execute(
                new CreateReviewRequest(
                    $request->input('user_id'),
                    $request->input('place_id'),
                    $request->input('description')
                )
            );
            return $this->successResponse($createReviewResponse->getModel()->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function updateReview(SaveReviewRequest $request, $id)
    {
        try {
            $updateReviewResponse = $this->updateReviewAction->execute(
                new UpdateReviewDescriptionRequest(
                    $request->input('description')
                ),
                $id
            );
            return $this->successResponse($updateReviewResponse->getModel()->toArray());
        } catch (ReviewNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function deleteReview($id)
    {
        $this->deleteReviewAction->execute(
            new DeleteReviewRequest($id)
        );
        return $this->successResponse([], 200);
    }
}
