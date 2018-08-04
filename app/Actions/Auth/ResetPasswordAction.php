<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\ResetPasswordRequest;
use Hedonist\Actions\Auth\Responses\ResetPasswordResponse;
use Hedonist\Entities\User;
use Hedonist\Exceptions\Auth\PasswordResetFailedException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;

class ResetPasswordAction
{
    public function execute(ResetPasswordRequest $request): ResetPasswordResponse
    {
        $token = '';
        $success = Password::broker()->reset($this->credentials($request), function ($user, $password) use ($token) {
            $token = $this->resetPassword($user, $password);
        });

        if ($success === Password::PASSWORD_RESET) {
            return new ResetPasswordResponse($token);
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

    private function resetPassword(User $user, string $password): string
    {
        $user->password = Hash::make($password);
        $user = $this->repository->save($user);
        $token = JWTAuth::login($user);

        return $token;
    }
}