<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Hedonist\Actions\Review\{
    GetReviewAction,
    UpdateReviewDescriptionAction,
    CreateReviewAction,
    DeleteReviewAction,
    GetReviewCollectionAction
};
use Hedonist\Actions\Review\{
    GetReviewPhotoByReviewAction,
    GetReviewPhotoByReviewRequest,
    GetReviewRequest,
    CreateReviewRequest,
    DeleteReviewRequest,
    UpdateReviewDescriptionRequest
};
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Http\Requests\Review\SaveReviewRequest;
use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;

class ReviewController extends ApiController
{
    private $getReviewAction;
    private $updateReviewAction;
    private $createReviewAction;
    private $deleteReviewAction;
    private $getReviewCollectionAction;
    private $getReviewPhotosByReviewAction;

    public function __construct(
        GetReviewAction $getReviewAction,
        CreateReviewAction $createReviewAction,
        DeleteReviewAction $deleteReviewAction,
        UpdateReviewDescriptionAction $updateReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction,
        GetReviewPhotoByReviewAction $getReviewPhotosByReviewAction
    ) {
        $this->getReviewAction = $getReviewAction;
        $this->updateReviewAction = $updateReviewAction;
        $this->createReviewAction = $createReviewAction;
        $this->deleteReviewAction = $deleteReviewAction;
        $this->getReviewCollectionAction = $getReviewCollectionAction;
        $this->getReviewPhotosByReviewAction = $getReviewPhotosByReviewAction;
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
        }
        catch (UserNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        }
        catch (PlaceDoesNotExistException $e) {
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

    public function getPhotosByReviewId(int $reviewId)
    {
        try {
            $reviewPhotosByReviewResponse = $this->getReviewPhotosByReviewAction->execute(new GetReviewPhotoByReviewRequest($reviewId));
            return $this->successResponse($reviewPhotosByReviewResponse->toArray(), 200);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
