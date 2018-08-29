<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\Criterias\GetTastesByUserWithNullCriteria;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Hedonist\Actions\UserTaste\GetTastesResponse;
use Illuminate\Support\Facades\Auth;

class GetTastesAction
{
    private $tasteRepository;
    
    public function __construct(TasteRepositoryInterface $repository)
    {
        $this->tasteRepository = $repository;
    }
    
    public function execute(): GetTastesResponse
    {
        $tastes = $this->tasteRepository->findByCriteria(new GetTastesByUserWithNullCriteria(Auth::id()));
 
        return new GetTastesResponse($tastes);
    }
}