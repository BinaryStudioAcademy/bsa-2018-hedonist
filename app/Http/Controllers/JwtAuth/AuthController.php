<?php

namespace Hedonist\Http\Controllers\JwtAuth;

use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Hedonist\Actions\Auth\RegisterUserAction;
use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Responses\RefreshResponse;
use Hedonist\Actions\LoginUserAction;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Hedonist\Http\Controllers\Controller;
use Hedonist\Requests\Auth\RegisterRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(\Hedonist\Http\Requests\Auth\LoginRequest $httpRequest,
        LoginUserAction $action)
    {
        try{

            $loginRequest = new LoginRequest($httpRequest->email, $httpRequest->password);
            $response = $action->execute($loginRequest);
            return response()->json(AuthPresenter::presentLoginResponse($response),200);

        }catch(AuthenticationException $exception){
            return response()->json(AuthPresenter::presentError($exception),401);
        }catch(JWTException $exception){
            return response()->json(AuthPresenter::presentError($exception),400);
        }
    }

    public function register(\Hedonist\Http\Requests\Auth\RegisterRequest $httpRequset,
                             RegisterUserAction $action)
    {
        try{
            $registerRequest = new RegisterRequest($httpRequset->email,$httpRequset->password,$httpRequset->name);
            $response = $action->execute($registerRequest);
            return response()->json(AuthPresenter::presentRegisterResponse($response),200);
        }catch(EmailAlreadyExistsException $exception){
            return response()->json(AuthPresenter::presentError($exception),400);
        }catch(JWTException $exception){
            return response()->json(AuthPresenter::presentError($exception),400);
        }catch(\Exception $exception){
            return response()->json(AuthPresenter::presentError($exception),500);
        }
    }

    public function me(Request $request)
    {
        return response()->json(AuthPresenter::presentUser(Auth::user()),200);
    }

    public function refresh()
    {
        return response()->json(AuthPresenter::presentRefreshResponse(
            new RefreshResponse(Auth::refresh())
        ));
    }

}
