<?php

namespace Hedonist\Http\Controllers\Api\User\UserTaste;

use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Actions\UserTaste\GetTastesAction;

class TasteController extends ApiController
{
    private $getTastesAction;

    public function __construct(GetTastesAction $getTastesAction)
    {
        $this->getTastesAction = $getTastesAction;
    }
    
    public function getTastes()
    {
        $getTastesResponse = $this->getTastesAction->execute();
        return $this->successResponse($getTastesResponse->getTastes());
    }
}