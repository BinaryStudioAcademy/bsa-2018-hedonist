<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Actions\UserTaste\AddUserTasteRequest;
use Hedonist\Actions\UserTaste\AddUserTasteResponse;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\UserTaste\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AddUserTasteAction
{
    private $userRepository;
    private $tasteRepository;

    public function __construct(UserRepositoryInterface $userRepository,TasteRepositoryInterface $tasteRepository)
    {
        $this->userRepository = $userRepository;
        $this->tasteRepository = $tasteRepository;
    }
    public function execute(AddUserTasteRequest $request): AddUserTasteResponse
    {
        $taste = $this->tasteRepository->getById($request->getTasteId());
        if($taste) {
            $this->userRepository->addTaste(Auth::user(),$taste);
            return new AddUserTasteResponse($taste);
        }
        throw new \LogicException('Taste not found!');
    }
}