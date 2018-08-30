<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Exceptions\User\TasteNotFoundException;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DeleteTasteAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $tasteRepository)
    {
        $this->tasteRepository = $tasteRepository;
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
        $this->tasteRepository->deleteById($deleteTasteRequest->getTasteId());
    }
}