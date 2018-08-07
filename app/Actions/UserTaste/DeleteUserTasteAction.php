<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Actions\UserTaste\DeleteUserTasteRequest;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DeleteUserTasteAction
{
    private $userRepository;
    private $tasteRepository;

    public function __construct(UserRepositoryInterface $userRepository,TasteRepositoryInterface $tasteRepository)
    {
        $this->userRepository = $userRepository;
        $this->tasteRepository = $tasteRepository;
    }
    public function execute(DeleteUserTasteRequest $request)
    {
         
        $taste = $this->tasteRepository->getById($request->getTasteId());
        if(!$taste) {
            throw new \LogicException('Taste not found!');
        }
        $this->userRepository->deleteTaste(Auth::user(),$taste);
        
    }
}