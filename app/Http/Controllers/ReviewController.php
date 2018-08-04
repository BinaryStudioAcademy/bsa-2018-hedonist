<?php

namespace Hedonist\Http\Controllers;

use Illuminate\Http\Request;
use Hedonist\Actions\Review\GetReviewCollectionAction;

class ReviewController extends ApiController
{
    private $getReviewCollectionAction;

    public function __construct(
        GetReviewCollectionAction $getReviewCollectionAction
    )
    {
        $this->getReviewCollectionAction = $getReviewCollectionAction;
    }

    public function getReviewCollection()
    {
        try {
            $getReviewCollectionResponse = $this->getReviewCollectionAction->execute();
            $this->successResponse($getReviewCollectionResponse->getCollection());
        } catch (\Exception $e) {
            $this->errorResponse($e->getMessage(), 400);
        }
    }

    public function getReview()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function edit($id)
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
