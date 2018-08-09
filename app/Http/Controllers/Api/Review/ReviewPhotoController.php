<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Illuminate\Support\Facades\Storage;
use Hedonist\Actions\Review\DeleteReviewPhotoAction;
use Hedonist\Actions\Review\DeleteReviewPhotoRequest;
use Hedonist\Actions\Review\SaveReviewPhotoRequest;
use Hedonist\Actions\Review\SaveReviewPhotoAction;
use Hedonist\Actions\Review\GetReviewPhotoAction;
use Hedonist\Actions\Review\GetReviewPhotoRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Review\ReviewPhotoRequest;

class ReviewPhotoController extends ApiController
{
    public $saveReviewPhotoAction;
    public $getReviewPhotoAction;
    public $deleteReviewPhotoAction;

    public function __construct(
        SaveReviewPhotoAction $saveReviewPhotoAction,
        GetReviewPhotoAction $getReviewPhotoAction,
        DeleteReviewPhotoAction $deleteReviewPhotoAction
    ) {
        $this->saveReviewPhotoAction = $saveReviewPhotoAction;
        $this->getReviewPhotoAction = $getReviewPhotoAction;
        $this->deleteReviewPhotoAction = $deleteReviewPhotoAction;
    }

    public function upload(ReviewPhotoRequest $request)
    {
        try {
            $file = $request->file('image');
            $newFileName = time() . '.' . $file->extension();
            $file->storeAs('public/upload/review', $newFileName);
            $responseReviewPhoto = $this->saveReviewPhotoAction->execute(
                new SaveReviewPhotoRequest(
                    $request->get('review_id'),
                    $request->get('description'),
                    $newFileName
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
            $responseReviewPhoto = $this->getReviewPhotoAction->execute(
                new GetReviewPhotoRequest($id)
            );
            Storage::delete('public/upload/review/' . $responseReviewPhoto->getImgUrl());
            $this->deleteReviewPhotoAction->execute(new DeleteReviewPhotoRequest($id));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}