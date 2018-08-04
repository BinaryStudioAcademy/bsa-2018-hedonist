<?php

namespace Hedonist\Http\Controllers;

use Illuminate\Http\Request;
use Hedonist\Actions\Review\GetReviewAction;
use Hedonist\Actions\Review\GetReviewRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\Review\GetReviewCollectionAction;

class ReviewController extends ApiController
{
    private $getReviewAction;
    private $getReviewCollectionAction;

    public function __construct(
        GetReviewAction $getReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction
    )
    {
        $this->getReviewAction = $getReviewAction;
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

    public function destroy($id)
    {
        //
    }
}

