<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\Criterias\GetTasteNamesCriteria;
use Hedonist\Repositories\User\TasteRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class GetTastesAutocompleteAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $repository)
    {
        $this->tasteRepository = $repository;
    }

    public function execute(GetTastesAutocompleteRequest $request): GetTastesAutocompleteResponse
    {
        $tastes = $this->tasteRepository->findByCriteria(new GetTasteNamesCriteria(Auth::id(), $request->getQuery()));

        return new GetTastesAutocompleteResponse($tastes);
    }
}