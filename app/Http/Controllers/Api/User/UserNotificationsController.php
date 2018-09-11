<?php

namespace Hedonist\Http\Controllers\Api\User;

use Hedonist\Actions\User\Notifications\DeleteNotificationsAction;
use Hedonist\Actions\User\Notifications\GetNotificationsAction;
use Hedonist\Actions\User\Notifications\GetNotificationsPresenter;
use Hedonist\Actions\User\Notifications\GetUnreadNotificationsAction;
use Hedonist\Actions\User\Notifications\ReadNotificationsAction;
use Hedonist\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;

class UserNotificationsController extends ApiController
{
    private $getNotificationsAction;
    private $getUnreadNotificationsAction;
    private $readNotificationsAction;
    private $deleteNotificationsAction;
    private $getNotificationsPresenter;

    public function __construct(
        GetNotificationsAction $getNotificationsAction,
        GetUnreadNotificationsAction $getUnreadNotificationsAction,
        ReadNotificationsAction $readNotificationsAction,
        DeleteNotificationsAction $deleteNotificationsAction,
        GetNotificationsPresenter $getNotificationsPresenter
    ) {
        $this->getNotificationsAction = $getNotificationsAction;
        $this->getUnreadNotificationsAction = $getUnreadNotificationsAction;
        $this->readNotificationsAction = $readNotificationsAction;
        $this->deleteNotificationsAction = $deleteNotificationsAction;
        $this->getNotificationsPresenter = $getNotificationsPresenter;
    }

    public function getNotifications(): JsonResponse
    {
        $response = $this->getNotificationsAction->execute();

        return $this->successResponse(
            $this->getNotificationsPresenter->presentCollection($response),
            201
        );
    }

    public function getUnreadNotifications(): JsonResponse
    {
        $response = $this->getUnreadNotificationsAction->execute();

        return $this->successResponse(
            $this->getNotificationsPresenter->presentCollection($response),
            201
        );
    }

    public function readNotifications(): JsonResponse
    {
        $this->readNotificationsAction->execute();

        return $this->emptyResponse();
    }

    public function deleteNotifications(): JsonResponse
    {
        $this->deleteNotificationsAction->execute();

        return $this->emptyResponse();
    }
}