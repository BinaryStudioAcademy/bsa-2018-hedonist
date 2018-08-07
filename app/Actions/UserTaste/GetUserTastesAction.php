<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Actions\UserTaste\GetUserTastesResponse;
use Illuminate\Support\Facades\Auth;

class GetUserTastesAction
{
    private $userRepository;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->userRepository = $repository;
    }
    public function execute(): GetUserTastesResponse
    {
       
        $tastes = $this->userRepository->getTastes(Auth::user());
       
        return new GetUserTastesResponse($tastes);
    }
}