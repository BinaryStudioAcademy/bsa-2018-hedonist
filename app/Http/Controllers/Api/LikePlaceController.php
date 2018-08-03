<?php

namespace Hedonist\Http\Controllers\Api;


class LikePlaceController extends ApiController
{
    public function like()
    {
        return successResponse('ok', 200);
    }

    public function dislike()
    {
        return successResponse('ok', 200);
    }
}