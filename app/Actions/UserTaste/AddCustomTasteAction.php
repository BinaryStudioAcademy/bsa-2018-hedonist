<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Entities\User\CustomTaste;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AddCustomTasteAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $tasteRepository)
    {
        $this->tasteRepository = $tasteRepository;
    }

    public function execute(AddCustomTasteRequest $addCustomTasteRequest): AddCustomTasteResponse
    {
        $customTaste = $this->tasteRepository->saveCustom(new CustomTaste([
            'name' => $addCustomTasteRequest->getName(),
            'user_id' => Auth::id()
        ]));

        return new AddCustomTasteResponse($customTaste);
    }
}