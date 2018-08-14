<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Hedonist\Actions\Review\DeleteReviewPhotoAction;
use Hedonist\Actions\Review\DeleteReviewPhotoRequest;
use Hedonist\Actions\Review\SaveReviewPhotoRequest;
use Hedonist\Actions\Review\SaveReviewPhotoAction;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Review\ReviewPhotoRequest;

class ReviewPhotoController extends ApiController
{
    public $saveReviewPhotoAction;
    public $deleteReviewPhotoAction;

    public function __construct(
        SaveReviewPhotoAction $saveReviewPhotoAction,
        DeleteReviewPhotoAction $deleteReviewPhotoAction
    ) {
        $this->saveReviewPhotoAction = $saveReviewPhotoAction;
        $this->deleteReviewPhotoAction = $deleteReviewPhotoAction;
    }

    public function upload(ReviewPhotoRequest $request)
    {
        try {
            $file = $request->file('img_url');
            $responseReviewPhoto = $this->saveReviewPhotoAction->execute(
                new SaveReviewPhotoRequest(
                    $request->get('review_id'),
                    $request->get('description'),
                    $file
                )
            );

            return $this->successResponse($responseReviewPhoto->toArray(), 201);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
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