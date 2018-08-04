<?php

namespace Hedonist\Http\Controllers;

use Hedonist\Actions\Review\DeleteReviewRequest;
use Illuminate\Http\Request;
use Hedonist\Actions\Review\GetReviewAction;
use Hedonist\Actions\Review\GetReviewRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\Review\GetReviewCollectionAction;

class ReviewController extends ApiController
{
    private $getReviewAction;
    private $deleteReviewAction;
    private $getReviewCollectionAction;

    public function __construct(
        GetReviewAction $getReviewAction,
        DeleteReviewRequest $deleteReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction
    )
    {
        $this->getReviewAction = $getReviewAction;
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

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
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

