<?php

namespace Hedonist\Actions\UserList;

class GetCollectionUserListAction
{
    public function execute(GetCollectionUserListRequest $request): GetCollectionUserListResponse
    {
        $responseCollection = new GetCollectionUserListResponse([]);
        return $responseCollection;
    }
}