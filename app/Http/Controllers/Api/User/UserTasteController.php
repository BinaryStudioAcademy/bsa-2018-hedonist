<?php

namespace Hedonist\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\UserTaste\GetUserTastesAction;
use Hedonist\Actions\UserTaste\AddUserTasteAction;
use Hedonist\Actions\UserTaste\DeleteUserTasteAction;
use Hedonist\Actions\UserTaste\AddUserTasteRequest;
use Hedonist\Actions\UserTaste\DeleteUserTasteRequest;

class UserTasteController extends ApiController
{
    private $getUserTastesAction;
    private $addUserTasteAction;
    private $deleteUserTasteAction;

    public function __construct(GetUserTastesAction $getUserTastesAction,AddUserTasteAction $addUserTasteAction,DeleteUserTasteAction $deleteUserTasteAction) {
        $this->getUserTastesAction = $getUserTastesAction;
        $this->addUserTasteAction = $addUserTasteAction;
        $this->deleteUserTasteAction = $deleteUserTasteAction;
    }
    public function getTastes() 
    {
        $getUserTastesResponse = $this->getUserTastesAction->execute();
        return $this->successResponse($getUserTastesResponse->getTastes());
    }
    public function addTaste(Request $request) 
    {
        try {
            $addUserTasteResponse = $this->addUserTasteAction->execute(
                new AddUserTasteRequest($request['taste_id'])
            );
            return $this->successResponse($addUserTasteResponse->getTaste(),201);
        }catch (\LogicException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
    }
    public function deleteTaste(int $tasteId)
    {
        try {
            $this->deleteUserTasteAction->execute(new DeleteUserTasteRequest($tasteId));
            return $this->successResponse([], 200);
        } catch (\LogicException $e) {
            return $this->errorResponse($e->getMessage(), 404);
        }
        
    }
}