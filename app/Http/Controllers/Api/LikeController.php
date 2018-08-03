<?php

namespace Hedonist\Http\Controllers\Api;


class LikeController extends ApiController
{
    public function likePlace()
    {
        return successResponse('ok', 200);
    }

    public function dislikePlace()
    {
        return successResponse('ok', 200);
    }
}