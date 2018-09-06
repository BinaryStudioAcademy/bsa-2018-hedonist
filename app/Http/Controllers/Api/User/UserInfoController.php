<?php

namespace Hedonist\Http\Controllers\Api\User;

use Hedonist\Actions\User\DeleteAvatarAction;
use Hedonist\Actions\User\DeleteAvatarRequest;
use Hedonist\Actions\User\GetUserInfoAction;
use Hedonist\Actions\User\GetUserInfoPresenter;
use Hedonist\Actions\User\GetUserInfoRequest;
use Hedonist\Actions\User\SaveUserInfoAction;
use Hedonist\Actions\User\SaveUserInfoRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\User\UserInfoHttpRequest;
use Illuminate\Http\JsonResponse;
use Hedonist\Exceptions\DomainException;

class UserInfoController extends ApiController
{
    private $saveUserInfoAction;
    private $getUserInfoAction;
    private $deleteAvatarAction;

    public function __construct(
        SaveUserInfoAction $saveUserInfoAction,
        GetUserInfoAction $getUserInfoAction,
        DeleteAvatarAction $deleteAvatarAction
    ) {
        $this->saveUserInfoAction = $saveUserInfoAction;
        $this->getUserInfoAction = $getUserInfoAction;
        $this->deleteAvatarAction = $deleteAvatarAction;
    }

    public function show(int $userId, GetUserInfoPresenter $presenter): JsonResponse
    {
        try {
            $response = $this->getUserInfoAction->execute(
                new GetUserInfoRequest($userId)
            );
        } catch (DomainException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse($presenter->present($response));
    }

    public function update(UserInfoHttpRequest $httpRequest, int $userId): JsonResponse
    {
        try {
            $response = $this->saveUserInfoAction->execute(
                new SaveUserInfoRequest(
                    $userId,
                    $httpRequest->first_name,
                    $httpRequest->last_name,
                    $httpRequest->date_of_birth,
                    $httpRequest->phone_number,
                    $httpRequest->file('avatar'),
                    $httpRequest->facebook_url,
                    $httpRequest->instagram_url,
                    $httpRequest->twitter_url,
                    $httpRequest->old_password,
                    $httpRequest->new_password,
                    $httpRequest->is_private
                )
            );
        } catch (DomainException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }

        return $this->successResponse([
            'user_id' => $response->getUserId(),
            'first_name' => $response->getFirstName(),
            'last_name' => $response->getLastName(),
            'date_of_birth' => $response->getDateOfBirth(),
            'phone_number' => $response->getPhoneNumber(),
            'avatar_url' => $response->getAvatarUrl(),
            'facebook_url' => $response->getFacebookUrl(),
            'instagram_url' => $response->getInstagramUrl(),
            'twitter_url' => $response->getTwitterUrl(),
            'is_private' => $response->getIsPrivate()
        ]);
    }

    public function deleteAvatar(int $userId): JsonResponse
    {
        try {
            $this->deleteAvatarAction->execute(new DeleteAvatarRequest($userId));

            return $this->emptyResponse();
        } catch (DomainException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }
    }
}