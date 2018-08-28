<?php

namespace Hedonist\Actions\UserTaste;

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
        $this->userRepository->deleteTaste(
            Auth::user(),
            $this->tasteRepository->getById($deleteTasteRequest->getTasteId()));
        $this->tasteRepository->deleteById($deleteTasteRequest->getTasteId());
    }
}