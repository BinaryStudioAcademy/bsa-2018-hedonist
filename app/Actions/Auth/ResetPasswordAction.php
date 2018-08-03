<?php

namespace Hedonist\Actions\Auth;


use Hedonist\Actions\ActionInterface;
use Hedonist\Actions\Auth\Responses\ResetResponse;
use Hedonist\Actions\RequestInterface;
use Hedonist\Actions\ResponseInterface;
use Hedonist\Events\Auth\PasswordResetedEvent;
use Hedonist\Repositories\User\UserRepositoryInterface;

class ResetPasswordAction implements ActionInterface
{
    private $repository;
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(RequestInterface $request): ResponseInterface
    {
        $token = $this->repository->addPasswordResetLink($request->getEmail());
        event(new PasswordResetedEvent($request->getEmail(), $token));
        return new ResetResponse(true);
    }
}