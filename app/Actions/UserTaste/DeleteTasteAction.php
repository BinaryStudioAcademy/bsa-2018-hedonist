<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Exceptions\User\TasteNotFoundException;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DeleteTasteAction
{
    private $tasteRepository;
    private $userRepository;

    public function __construct(TasteRepositoryInterface $tasteRepository, UserRepositoryInterface $userRepository)
    {
        $this->tasteRepository = $tasteRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteTasteRequest $deleteTasteRequest)
    {
        $taste = $this->tasteRepository->getById($deleteTasteRequest->getTasteId());
        if (!$taste) {
            throw new TasteNotFoundException;
        }
        if ($taste->user_id !== Auth::id()) {
            throw new TasteNotFoundException;
        }
        $this->userRepository->deleteTaste(
            Auth::user(),
            $taste);
        $this->tasteRepository->deleteById($deleteTasteRequest->getTasteId());
    }
}