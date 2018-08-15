<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\CheckEmailUniqueRequest;
use Hedonist\Actions\Auth\Responses\CheckEmailUniqueResponse;
use Hedonist\Repositories\User\UserRepositoryInterface;

class CheckEmailUniqueAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CheckEmailUniqueRequest $request): CheckEmailUniqueResponse
    {
        $isEmailUnique = $this->repository->isEmailUnique($request->getEmail());
        return new CheckEmailUniqueResponse($isEmailUnique, $request->getEmail());
    }
}