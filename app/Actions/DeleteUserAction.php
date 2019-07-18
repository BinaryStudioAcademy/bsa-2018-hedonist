<?php

declare(strict_types=1);

namespace Hedonist\Actions\Auth;

use Hedonist\Exceptions\NonAuthorizedException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

final class DeleteUserAction
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(DeleteUserRequest $request): void
    {
        $user = Auth::user();

        if ($user->id !== (int)$request->getUserId()) {
            throw new NonAuthorizedException();
        }

        Auth::logout();

        $this->userRepository->deleteById($user->id);
    }
}
