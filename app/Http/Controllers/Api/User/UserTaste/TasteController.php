<?php

namespace Hedonist\Http\Controllers\Api\User\UserTaste;

use Hedonist\Actions\UserTaste\AddTasteAction;
use Hedonist\Actions\UserTaste\AddTasteRequest;
use Hedonist\Actions\UserTaste\DeleteTasteAction;
use Hedonist\Actions\UserTaste\DeleteTasteRequest;
use Hedonist\Exceptions\DomainException;
use Hedonist\Exceptions\User\TasteNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\UserTaste\GetTastesAction;
use Illuminate\Http\Request;

class TasteController extends ApiController
{
    private $getTastesAction;
    private $addTasteAction;
    private $deleteTasteAction;

    public function __construct(
        GetTastesAction $getTastesAction,
        AddTasteAction $addTasteAction,
        DeleteTasteAction $deleteTasteAction
    ) {
        $this->getTastesAction = $getTastesAction;
        $this->addTasteAction = $addTasteAction;
        $this->deleteTasteAction = $deleteTasteAction;
    }
    
    public function getTastes()
    {
        $getTastesResponse = $this->getTastesAction->execute();
        return $this->successResponse($getTastesResponse->getTastes());
    }

    public function addTaste(Request $request)
    {
        try {
            $addTasteResponse = $this->addTasteAction->execute(
                new AddTasteRequest($request['name'])
            );
            return $this->successResponse($addTasteResponse->getTaste(), 201);
        } catch (DomainException $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
    }

    public function deleteTaste(int $tasteId)
    {
        try {
            $this->deleteTasteAction->execute(new DeleteTasteRequest($tasteId));
            return $this->emptyResponse(200);
        } catch (TasteNotFoundException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
}