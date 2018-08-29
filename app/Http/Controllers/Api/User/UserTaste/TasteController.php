<?php

namespace Hedonist\Http\Controllers\Api\User\UserTaste;

use Hedonist\Actions\UserTaste\AddCustomTasteAction;
use Hedonist\Actions\UserTaste\AddCustomTasteRequest;
use Hedonist\Actions\UserTaste\DeleteCustomTasteAction;
use Hedonist\Actions\UserTaste\DeleteCustomTasteRequest;
use Hedonist\Actions\UserTaste\GetCustomTastesAction;
use Hedonist\Exceptions\DomainException;
use Hedonist\Exceptions\User\TasteNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\UserTaste\GetTastesAction;
use Illuminate\Http\Request;

class TasteController extends ApiController
{
    private $getTastesAction;
    private $getCustomTastesAction;
    private $addCustomTasteAction;
    private $deleteCustomTasteAction;

    public function __construct(
        GetTastesAction $getTastesAction,
        GetCustomTastesAction $getCustomTastesAction,
        AddCustomTasteAction $addCustomTasteAction,
        DeleteCustomTasteAction $deleteCustomTasteAction
    ) {
        $this->getTastesAction = $getTastesAction;
        $this->getCustomTastesAction = $getCustomTastesAction;
        $this->addCustomTasteAction = $addCustomTasteAction;
        $this->deleteCustomTasteAction = $deleteCustomTasteAction;
    }
    
    public function getTastes()
    {
        $getTastesResponse = $this->getTastesAction->execute();
        return $this->successResponse($getTastesResponse->getTastes());
    }

    public function getCustomTastes()
    {
        $getCustomTastesResponse = $this->getCustomTastesAction->execute();
        return $this->successResponse($getCustomTastesResponse->getCustomTastes());
    }

    public function addCustomTaste(Request $request)
    {
        try {
            $addCustomTasteResponse = $this->addCustomTasteAction->execute(
                new AddCustomTasteRequest($request['name'])
            );
            return $this->successResponse($addCustomTasteResponse->getTaste(), 201);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function deleteCustomTaste(int $tasteId)
    {
        try {
            $this->deleteCustomTasteAction->execute(new DeleteCustomTasteRequest($tasteId));
            return $this->emptyResponse(200);
        } catch (TasteNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}