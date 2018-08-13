<?php

namespace Hedonist\Http\Controllers\Api\User;

use Hedonist\Actions\User\GetUserInfoAction;
use Hedonist\Actions\User\GetUserInfoRequest;
use Hedonist\Actions\User\SaveUserInfoAction;
use Hedonist\Actions\User\SaveUserInfoRequest;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\User\UserInfoHttpRequest;
use Illuminate\Http\JsonResponse;

class UserInfoController extends ApiController
{
    private $saveUserInfoAction;
    private $getUserInfoAction;

    public function __construct(
        SaveUserInfoAction $saveUserInfoAction,
        GetUserInfoAction $getUserInfoAction
    ) {
        $this->saveUserInfoAction = $saveUserInfoAction;
        $this->getUserInfoAction = $getUserInfoAction;
    }

    public function show(int $userId): JsonResponse
    {
        try {
            $response = $this->getUserInfoAction->execute(
                new GetUserInfoRequest($userId)
            );
        } catch (\Exception $ex) {
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
        ]);
    }

    public function update(UserInfoHttpRequest $httpRequest, int $userId): JsonResponse
    {
        try {
            $avatar = $httpRequest->file('avatar_url');
            if ($avatar !== null) {
                $avatarUrl = $userId . '.' . $avatar->extension();
                $avatar->storeAs('public/upload/avatar', $avatarUrl);
            } else {
                $avatarUrl = "";
            }

            $response = $this->saveUserInfoAction->execute(
                new SaveUserInfoRequest(
                    $userId,
                    $httpRequest->first_name,
                    $httpRequest->last_name,
                    $httpRequest->date_of_birth,
                    $httpRequest->phone_number,
                    $avatarUrl,
                    $httpRequest->facebook_url,
                    $httpRequest->instagram_url,
                    $httpRequest->twitter_url
                )
            );
        } catch (\Exception $ex) {
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
        ]);
    }
}