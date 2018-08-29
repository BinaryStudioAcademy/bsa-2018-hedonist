<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Exceptions\User\CustomTasteNotFoundException;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DeleteCustomTasteAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $tasteRepository)
    {
        $this->tasteRepository = $tasteRepository;
    }

    public function execute(DeleteCustomTasteRequest $deleteCustomTasteRequest)
    {
        $customTaste = $this->tasteRepository->getCustomById($deleteCustomTasteRequest->getCustomTasteId());
        if (!$customTaste) {
            throw new CustomTasteNotFoundException('Custom taste not found!');
        }
        $this->tasteRepository->deleteCustomById($deleteCustomTasteRequest->getCustomTasteId());
    }
}