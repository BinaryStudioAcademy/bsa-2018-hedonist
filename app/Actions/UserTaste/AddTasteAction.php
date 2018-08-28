<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Entities\User\Taste;
use Hedonist\Repositories\User\TasteRepository;
use Illuminate\Support\Facades\Auth;

class AddTasteAction
{
    private $tasteRepository;

    public function __construct(TasteRepository $tasteRepository)
    {
        $this->tasteRepository = $tasteRepository;
    }

    public function execute(AddTasteRequest $addTasteRequest): AddTasteResponse
    {
        $taste = $this->tasteRepository->save(new Taste([
            'name' => $addTasteRequest->getName(),
            'user_id' => Auth::id()
        ]));

        return new AddTasteResponse($taste);
    }
}