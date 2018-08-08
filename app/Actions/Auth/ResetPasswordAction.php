<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\ResetPasswordRequest;
use Hedonist\Actions\Auth\Responses\ResetPasswordResponse;
use Hedonist\Entities\User\User;
use Hedonist\Exceptions\Auth\PasswordResetFailedException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordAction
{
    private $token;
    private $repository;
    private $broker;

    public function __construct(UserRepositoryInterface $repository, PasswordBroker $broker)
    {
        $this->repository = $repository;
        $this->broker = $broker;
    }

    public function execute(ResetPasswordRequest $request): ResetPasswordResponse
    {
        $success = $this->broker->reset($this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($success === Password::PASSWORD_RESET) {
            return new ResetPasswordResponse($this->token);
        } else {
            throw new PasswordResetFailedException();
        }
    }

    private function credentials(ResetPasswordRequest $request): array
    {
        return [
            'email' => $request->getEmail(),
            'password' => $request->getPassword(),
            'password_confirmation' => $request->getPasswordConfirmation(),
            'token' => $request->getToken()
        ];
    }

    private function resetPassword(User $user, string $password): void
    {
        $user->password = Hash::make($password);
        $user = $this->repository->save($user);
        $this->token = Auth::login($user);
    }
}