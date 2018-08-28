<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\TasteRepository;

class DeleteTasteAction
{
    private $tasteRepository;

    public function __construct(TasteRepository $tasteRepository)
    {
        $this->tasteRepository = $tasteRepository;
    }

    public function execute(DeleteTasteRequest $deleteTasteRequest)
    {
        $this->tasteRepository->deleteById($deleteTasteRequest->getTasteId());
    }
}