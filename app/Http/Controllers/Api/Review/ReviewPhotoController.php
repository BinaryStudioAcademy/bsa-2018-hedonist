<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Hedonist\Actions\Review\DeleteReviewPhotoAction;
use Hedonist\Actions\Review\DeleteReviewPhotoRequest;
use Hedonist\Actions\Review\SaveReviewPhotoRequest;
use Hedonist\Actions\Review\SaveReviewPhotoAction;
use Hedonist\Actions\Review\GetCollectionReviewPhotoAction;
use Hedonist\Actions\Review\GetReviewPhotoAction;
use Hedonist\Actions\Review\GetReviewPhotoRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Review\ReviewPhotoRequest;

class ReviewPhotoController extends ApiController
{
    public $saveReviewPhotoAction;
    public $collectionReviewPhotoAction;
    public $getReviewPhotoAction;
    public $deleteReviewPhotoAction;

    public function __construct(
        SaveReviewPhotoAction $saveReviewPhotoAction,
        GetCollectionReviewPhotoAction $collectionReviewPhotoAction,
        GetReviewPhotoAction $getReviewPhotoAction,
        DeleteReviewPhotoAction $deleteReviewPhotoAction
    ) {
        $this->saveReviewPhotoAction = $saveReviewPhotoAction;
        $this->collectionReviewPhotoAction = $collectionReviewPhotoAction;
        $this->getReviewPhotoAction = $getReviewPhotoAction;
        $this->deleteReviewPhotoAction = $deleteReviewPhotoAction;
    }

    public function index()
    {
        $responseReviewPhoto = $this->collectionReviewPhotoAction->execute();
        return $this->successResponse($responseReviewPhoto->toArray(), 200);
    }

    public function store(ReviewPhotoRequest $request)
    {
        try {
            $responseReviewPhoto = $this->saveReviewPhotoAction->execute(
                new SaveReviewPhotoRequest(
                    $request->get('review_id'),
                    $request->get('description'),
                    $request->get('img_url')
                )
            );
            return $this->successResponse($responseReviewPhoto->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function show(int $id)
    {
        try {
            $responseReviewPhoto = $this->getReviewPhotoAction->execute(
                new GetReviewPhotoRequest($id)
            );
            return $this->successResponse($responseReviewPhoto->toArray(), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
    }

    public function update(ReviewPhotoRequest $request, int $id)
    {
        try {
            $responseReviewPhoto = $this->saveReviewPhotoAction->execute(
                new SaveReviewPhotoRequest(
                    $request->get('review_id'),
                    $request->get('description'),
                    $request->get('img_url'),
                    $id
                )
            );
            return $this->successResponse($responseReviewPhoto->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->deleteReviewPhotoAction->execute(new DeleteReviewPhotoRequest($id));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}