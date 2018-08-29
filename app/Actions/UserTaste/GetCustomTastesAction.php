<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetCustomTastesAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $repository)
    {
        $this->tasteRepository = $repository;
    }

    public function execute(): GetCustomTastesResponse
    {
        $customTastes = $this->tasteRepository->getCustomByUserId(Auth::id());

        return new GetCustomTastesResponse($customTastes);
    }
}