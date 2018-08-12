<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Repositories\User\TasteRepositoryInterface;

class GetTastesAction
{
    private $tasteRepository;

    public function __construct(TasteRepositoryInterface $repository)
    {
        $this->tasteRepository = $repository;
    }

    public function execute(): GetTastesResponse
    {
        $tastes = $this->tasteRepository->findAll();

        return new GetTastesResponse($tastes);
    }
}