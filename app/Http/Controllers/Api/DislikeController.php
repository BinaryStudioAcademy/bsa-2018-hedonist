<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Dislike\{
    DislikePlaceAction,
    DislikePlaceRequest
};

class DislikeController extends ApiController
{
    private $dislikePlaceAction;

    public function __construct(DislikePlaceAction $dislikePlaceAction)
    {
        $this->dislikePlaceAction = $dislikePlaceAction;
    }

    public function dislikePlace(int $id)
    {
        try {
            $response = $this->dislikePlaceAction->execute(
                new DislikePlaceRequest($id)
            );
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), 400);
        }
        return $this->successResponse('ok', 200);
    }
}