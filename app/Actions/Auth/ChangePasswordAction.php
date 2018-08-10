<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\ChangePasswordRequest;
use Hedonist\Entities\User\User;
use Hedonist\Exceptions\Auth\PasswordsDosentMatchException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ChangePasswordRequest $request):void
    {
        $user = Auth::user();
        $this->validate($user,$request);
        $user->password = Hash::make($request->getNewPassword());
        $this->repository->save($user);
    }

    private function validate(User $user,ChangePasswordRequest $request):void
    {
        if(!Hash::check($request->getOldPassword(),$user->getAuthPassword())){
            throw new PasswordsDosentMatchException();
        }
    }
}