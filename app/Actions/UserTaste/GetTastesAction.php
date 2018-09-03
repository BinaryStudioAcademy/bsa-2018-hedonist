<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\Criterias\GetTastesByUserWithCriteria;
use Hedonist\Repositories\User\TasteRepositoryInterface;
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
        $tastes = $this->tasteRepository->findByCriteria(new GetTastesByUserWithCriteria(Auth::id()));
 
        return new GetTastesResponse($tastes);
    }
}