<?php

namespace Hedonist\Actions\UserTaste;

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
        $this->tasteRepository->deleteCustomById($deleteCustomTasteRequest->getCustomTasteId());
    }
}