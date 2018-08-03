<?php

namespace Hedonist\Http\Controllers;

use Hedonist\Actions\Auth\LoginUserAction;
use Hedonist\Actions\Auth\RegisterUserAction;
use Hedonist\Http\Requests\Auth\LoginRequest;
use Hedonist\Http\Requests\Auth\RegisterRequestInterface;
use Hedonist\Requests\Auth\LoginUserRequestInterface;
use Hedonist\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(LoginRequestInterface $request,LoginUserAction $action){
    }

    public function register(RegisterRequestInterface $request,RegisterUserAction $action){
    }

    public function logout(Request $request){

    }

    public function recoverPassword(RecoverPasswordRequest $request){
    }

    public function getUser(){
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ],200);
    }
}
