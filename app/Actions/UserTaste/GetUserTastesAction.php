<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\TasteRepositoryInterface;
use Hedonist\Actions\UserTaste\GetUserTastesResponse;
use Illuminate\Support\Facades\Auth;

class GetUserTastesAction
{
    private $tasteRepository;
    
    public function __construct(TasteRepositoryInterface $repository)
    {
        $this->tasteRepository = $repository;
    }
    
    public function execute(): GetUserTastesResponse
    {
        $tastes = $this->tasteRepository->findByUser(Auth::id());
       
        return new GetUserTastesResponse($tastes);
    }
}