<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Entities\User\Taste;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class AddTasteAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $tasteRepository)
    {
        $this->tasteRepository = $tasteRepository;
    }

    public function execute(AddTasteRequest $addTasteRequest): AddTasteResponse
    {
        $name = $addTasteRequest->getName();
        $taste = $this->tasteRepository->getByName($name);

        if($taste === null) {
            $taste = $this->tasteRepository->save(new Taste([
                'name' => $addTasteRequest->getName(),
                'user_id' => Auth::id()
            ]));
        }

        return new AddTasteResponse($taste);
    }
}