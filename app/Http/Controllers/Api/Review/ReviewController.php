<?php

namespace Hedonist\Http\Controllers\Api\Review;

use Hedonist\Actions\Presenters\Review\ReviewPresenter;
use Hedonist\Actions\Review\{
    GetReviewAction,
    UpdateReviewDescriptionAction,
    CreateReviewAction,
    DeleteReviewAction,
    GetReviewCollectionAction,
    GetUsersWhoLikedReviewAction,
    GetUsersWhoDislikedReviewAction
};
use Hedonist\Actions\Review\{
    GetLikeStatusForReviews\GetLikeStatusForReviewsAction,
    GetLikeStatusForReviews\GetLikeStatusForReviewsRequest,
    GetReviewPhotoByPlaceAction,
    GetReviewPhotoByPlaceRequest,
    GetReviewPhotoByReviewAction,
    GetReviewPhotoByReviewRequest,
    GetReviewRequest,
    CreateReviewRequest,
    DeleteReviewRequest,
    UpdateReviewDescriptionRequest,
    GetUsersWhoLikedReviewRequest,
    GetUsersWhoDislikedReviewRequest,
    GetReviewCollectionRequest
};
use Hedonist\Exceptions\DomainException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Http\Requests\Review\SaveReviewRequest;
use Hedonist\Exceptions\Review\ReviewNotFoundException;
use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Hedonist\Http\Requests\Review\ReviewSearchRequest;
use Hedonist\Actions\Presenters\User\UserPresenter;
use Illuminate\Http\JsonResponse;

class ReviewController extends ApiController
{
    private $getReviewAction;
    private $updateReviewAction;
    private $createReviewAction;
    private $deleteReviewAction;
    private $getReviewCollectionAction;
    private $getReviewPhotosByReviewAction;
    private $getUsersWhoLikedReviewAction;
    private $getUsersWhoDislikedReviewAction;
    private $getReviewPhotoByPlaceAction;
    private $getLikeStatusForReviewsAction;
    private $reviewPresenter;

    public function __construct(
        GetReviewAction $getReviewAction,
        CreateReviewAction $createReviewAction,
        DeleteReviewAction $deleteReviewAction,
        UpdateReviewDescriptionAction $updateReviewAction,
        GetReviewCollectionAction $getReviewCollectionAction,
        GetReviewPhotoByReviewAction $getReviewPhotosByReviewAction,
        GetUsersWhoLikedReviewAction $getUsersWhoLikedReviewAction,
        GetUsersWhoDislikedReviewAction $getUsersWhoDislikedReviewAction,
        GetReviewPhotoByPlaceAction $getReviewPhotoByPlaceAction,
        GetLikeStatusForReviewsAction $getLikeStatusForReviewsAction,
        ReviewPresenter $reviewPresenter
    ) {
        $this->getReviewAction = $getReviewAction;
        $this->updateReviewAction = $updateReviewAction;
        $this->createReviewAction = $createReviewAction;
        $this->deleteReviewAction = $deleteReviewAction;
        $this->getReviewCollectionAction = $getReviewCollectionAction;
        $this->getReviewPhotosByReviewAction = $getReviewPhotosByReviewAction;
        $this->getUsersWhoLikedReviewAction = $getUsersWhoLikedReviewAction;
        $this->getUsersWhoDislikedReviewAction = $getUsersWhoDislikedReviewAction;
        $this->getReviewPhotoByPlaceAction = $getReviewPhotoByPlaceAction;
        $this->getLikeStatusForReviewsAction = $getLikeStatusForReviewsAction;
        $this->reviewPresenter = $reviewPresenter;
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

    public function getReviewCollection(ReviewSearchRequest $request): JsonResponse
    {
        try {
            $getReviewCollectionResponse = $this->getReviewCollectionAction->execute(
                new GetReviewCollectionRequest(
                    $request->input('page'),
                    $request->input('filter.place_id'),
                    $request->input('sort'),
                    $request->input('order'),
                    $request->input('filter.text')
                )
            );

            $getLikeStatusForReviewsResponse = $this->getLikeStatusForReviewsAction->execute(
                new GetLikeStatusForReviewsRequest(
                    $getReviewCollectionResponse->getReviewCollection()
                )
            );

            return $this->successResponseWithMeta(
                $this->reviewPresenter->presentCollection($getLikeStatusForReviewsResponse->getReviewCollection()),
                $getReviewCollectionResponse->getPaginationMetaInfo()
            );
        } catch (DomainException $e) {
            return $this->errorResponse($e->getMessage());
        }
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
        } catch (UserNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 400);
        } catch (PlaceDoesNotExistException $e) {
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
            $reviewPhotosByReviewResponse = $this->getReviewPhotosByReviewAction->execute(
                new GetReviewPhotoByReviewRequest($reviewId)
            );
            return $this->successResponse($reviewPhotosByReviewResponse->toArray(), 200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function getUsersWhoLikedReview(int $id, UserPresenter $presenter)
    {
        try {
            $getUsersWhoLikedReviewResponse = $this->getUsersWhoLikedReviewAction->execute(
                new GetUsersWhoLikedReviewRequest($id)
            );
            $users = $getUsersWhoLikedReviewResponse->getUsers();
            $presented = [];
            foreach ($users as $user) {
                $presented[] = $presenter->present($user);
            }
            return $this->successResponse($presented, 200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function getUsersWhoDislikedReview(int $id, UserPresenter $presenter)
    {
        try {
            $getUsersWhoDislikedReviewResponse = $this->getUsersWhoDislikedReviewAction->execute(
                new GetUsersWhoDislikedReviewRequest($id)
            );
            $users = $getUsersWhoDislikedReviewResponse->getUsers();
            $presented = [];
            foreach ($users as $user) {
                $presented[] = $presenter->present($user);
            }
            return $this->successResponse($presented, 200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function getReviewPhotosByPlaceId(int $placeId)
    {
        try {
            $reviewPhotosByReviewResponse = $this->getReviewPhotoByPlaceAction->execute(
                new GetReviewPhotoByPlaceRequest($placeId)
            );

            return $this->successResponse($reviewPhotosByReviewResponse->toArray(), 200);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }
}
