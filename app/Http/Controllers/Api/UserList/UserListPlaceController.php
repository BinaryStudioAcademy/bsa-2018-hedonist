<?php

namespace Hedonist\Http\Controllers\Api\UserList;

use Hedonist\Actions\UserList\Places\{
    AttachPlaceAction,
    AttachPlaceRequest
};

class UserListPlaceController extends ApiController
{
    public $attachPlaceAction;

    public function __construct( AttachPlaceAction $attachPlaceAction) 
    {
        $this->attachPlaceAction = $attachPlaceAction;
    }

    public function attachPlace()
    {
                
    }
}
