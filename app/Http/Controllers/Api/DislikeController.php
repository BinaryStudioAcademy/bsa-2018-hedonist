<?php

namespace Hedonist\Http\Controllers\Api;

use Hedonist\Actions\Dislike\{
    DislikePlaceAction,
    DislikePlaceRequest
};
use Hedonist\Exceptions\Place\PlaceNotFoundException;

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
        } catch (PlaceNotFoundException $exception) {
            return $this->errorResponse('Place not found', 404);
        }
        return $this->successResponse([], 200);
    }
}