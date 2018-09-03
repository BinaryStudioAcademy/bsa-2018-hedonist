<?php

namespace Hedonist\Http\Controllers\Api\User\UserTaste;

use Hedonist\Actions\Presenters\Taste\TasteAutocompletePresenter;
use Hedonist\Actions\UserTaste\GetTastesAction;
use Hedonist\Actions\UserTaste\GetTastesAutocompleteAction;
use Hedonist\Actions\UserTaste\AddTasteAction;
use Hedonist\Actions\UserTaste\AddTasteRequest;
use Hedonist\Actions\UserTaste\DeleteTasteAction;
use Hedonist\Actions\UserTaste\DeleteTasteRequest;
use Hedonist\Actions\UserTaste\GetTastesAutocompleteRequest;
use Hedonist\Exceptions\DomainException;
use Hedonist\Exceptions\User\TasteNotFoundException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\UserTaste\AddTasteHttpRequest;
use Illuminate\Http\Request;

class TasteController extends ApiController
{
    private $getTastesAction;
    private $getTastesAutocompleteAction;
    private $addTasteAction;
    private $deleteTasteAction;

    public function __construct(
        GetTastesAction $getTastesAction,
        GetTastesAutocompleteAction $getTastesAutocompleteAction,
        AddTasteAction $addTasteAction,
        DeleteTasteAction $deleteTasteAction
    ) {
        $this->getTastesAction = $getTastesAction;
        $this->getTastesAutocompleteAction = $getTastesAutocompleteAction;
        $this->addTasteAction = $addTasteAction;
        $this->deleteTasteAction = $deleteTasteAction;
    }
    
    public function getTastes()
    {
        $getTastesResponse = $this->getTastesAction->execute();
        return $this->successResponse($getTastesResponse->getTastes());
    }

    public function getTastesAutocomplete(Request $request, TasteAutocompletePresenter $presenter)
    {
        $getTastesAutocompleteResponse = $this->getTastesAutocompleteAction->execute(
            new GetTastesAutocompleteRequest((string)$request['query'])
        );

        return $this->successResponse($presenter->present($getTastesAutocompleteResponse));
    }

    public function addTaste(AddTasteHttpRequest $request)
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