<?php

namespace Hedonist\Http\Controllers\Api\User;

use Hedonist\Actions\User\Notifications\DeleteNotificationsAction;
use Hedonist\Actions\User\Notifications\DeleteNotificationsRequest;
use Hedonist\Actions\User\Notifications\GetNotificationsAction;
use Hedonist\Actions\User\Notifications\GetNotificationsPresenter;
use Hedonist\Actions\User\Notifications\GetNotificationsRequest;
use Hedonist\Actions\User\Notifications\GetUnreadNotificationsAction;
use Hedonist\Actions\User\Notifications\ReadNotificationsAction;
use Hedonist\Actions\User\Notifications\ReadNotificationsRequest;
use Hedonist\Http\Controllers\Api\ApiController;

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

    public function getNotifications()
    {
        $response = $this->getNotificationsAction->execute(new GetNotificationsRequest());

        return $this->successResponse(
            $this->getNotificationsPresenter->presentCollection($response),
            201
        );
    }

    public function getUnreadNotifications()
    {
        $response = $this->getUnreadNotificationsAction->execute(new GetNotificationsRequest());

        return $this->successResponse(
            $this->getNotificationsPresenter->presentCollection($response),
            201
        );
    }

    public function readNotifications()
    {
        $this->readNotificationsAction->execute(new ReadNotificationsRequest());

        return $this->emptyResponse();
    }

    public function deleteNotifications()
    {
        $this->deleteNotificationsAction->execute(new DeleteNotificationsRequest());

        return $this->emptyResponse();
    }
}