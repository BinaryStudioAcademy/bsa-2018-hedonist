<?php

namespace Hedonist\Http\Controllers;

use Hedonist\Actions\Review\{
    GetReviewAction,
    UpdateReviewAction,
    CreateReviewAction,
    DeleteReviewAction,
    GetReviewCollectionAction
};

use Hedonist\Actions\Review\{
    GetReviewRequest,
    UpdateReviewRequest,
    CreateReviewRequest,
    DeleteReviewRequest
};

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\ReviewCreateUpdateRequest;


class ReviewController extends ApiController
{
    private $getReviewAction;
    private $updateReviewAction;
    private $createReviewAction;
    private $deleteReviewAction;
    private $getReviewCollectionAction;

    public function __construct(
        GetReviewAction $getReviewAction,
        UpdateReviewAction $updateReviewAction,
        CreateReviewAction $createReviewAction,
        DeleteReviewAction $deleteReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction
    )
    {
        $this->getReviewAction = $getReviewAction;
        $this->updateReviewAction = $updateReviewAction;
        $this->createReviewAction = $createReviewAction;
        $this->deleteReviewAction = $deleteReviewAction;
        $this->getReviewCollectionAction = $getReviewCollectionAction;
    }

    public function getReview(int $id): void
    {
        try {
            $getReviewResponse = $this->getReviewAction->execute(
                new GetReviewRequest($id)
            );
            $this->successResponse($getReviewResponse->getReview());
        } catch (\LogicException $e) {
            $this->errorResponse($e->getMessage(), 404);
        }
    }

    public function getReviewCollection(): void
    {
        $getReviewCollectionResponse = $this->getReviewCollectionAction->execute();
        $this->successResponse($getReviewCollectionResponse->getReviewCollection());
    }

    public function createReview(ReviewCreateUpdateRequest $request): void
    {
        try {
            $createReviewResponse = $this->createReviewAction->execute(
                new CreateReviewRequest(
                    $request->input('user_id'),
                    $request->input('place_id'),
                    $request->input('description')
                )
            );
            $this->successResponse($createReviewResponse->getModel());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function updateReview(ReviewCreateUpdateRequest $request): void
    {
        try {
            $updateReviewResponse = $this->updateReviewAction->execute(
                new UpdateReviewRequest(
                    $request->input('user_id'),
                    $request->input('place_id'),
                    $request->input('description')
                )
            );
            $this->successResponse($updateReviewResponse->getModel());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function deleteReview($id): void
    {
        $this->deleteReviewAction->execute(
            new DeleteReviewRequest($id)
        );
    }
}
