<?php

namespace Hedonist\Http\Controllers;

use Illuminate\Http\Request;
use Hedonist\Actions\Review\GetReviewAction;
use Hedonist\Actions\Review\GetReviewRequest;
use Hedonist\Actions\Review\EditReviewAction;
use Hedonist\Actions\Review\EditReviewRequest;
use Hedonist\Actions\Review\CreateReviewAction;
use Hedonist\Actions\Review\CreateReviewRequest;
use Hedonist\Actions\Review\DeleteReviewRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\Review\GetReviewCollectionAction;

class ReviewController extends ApiController
{
    private $getReviewAction;
    private $editReviewAction;
    private $createReviewAction;
    private $deleteReviewAction;
    private $getReviewCollectionAction;

    public function __construct(
        GetReviewAction $getReviewAction,
        EditReviewAction $editReviewAction,
        CreateReviewAction $createReviewAction,
        DeleteReviewRequest $deleteReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction
    )
    {
        $this->getReviewAction = $getReviewAction;
        $this->editReviewAction = $editReviewAction;
        $this->createReviewAction = $createReviewAction;
        $this->deleteReviewAction = $deleteReviewAction;
        $this->getReviewCollectionAction = $getReviewCollectionAction;
    }

    public function getReview($id)
    {
        try {
            $getReviewResponse = $this->getReviewAction->execute(
                new GetReviewRequest($id)
            );
            $this->successResponse($getReviewResponse->getReview());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function getReviewCollection()
    {
        try {
            $getReviewCollectionResponse = $this->getReviewCollectionAction->execute();
            $this->successResponse($getReviewCollectionResponse->getReviewCollection());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function createReview(Request $request)
    {
        try {
            $createReviewResponse = $this->createReviewAction->execute(
                /* Review model does NOT created at the moment */
                new CreateReviewRequest(
                    $request->input('title'),
                    $request->input('body')
                )
            );
            $this->successResponse($createReviewResponse->getModel());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $editReviewResponse = $this->editReviewAction->execute(
            /* Review model does NOT created at the moment */
                new EditReviewRequest(
                    $request->input('title'),
                    $request->input('body')
                )
            );
            $this->successResponse($editReviewResponse->getModel());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function deleteReview($id)
    {
        try {
            $this->deleteReviewAction->execute(
                new DeleteReviewRequest($id)
            );
            $this->successResponse([]);
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }
}
