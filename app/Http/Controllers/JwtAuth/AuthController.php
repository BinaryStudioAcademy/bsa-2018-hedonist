<?php

namespace Hedonist\Http\Controllers\JwtAuth;

use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Hedonist\Actions\Auth\RecoverPasswordAction;
use Hedonist\Actions\Auth\RegisterUserAction;
use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Requests\RecoverPasswordRequest;
use Hedonist\Actions\Auth\Requests\ResetPasswordRequest;
use Hedonist\Actions\Auth\ResetPasswordAction;
use Hedonist\Actions\Auth\Responses\RefreshResponse;
use Hedonist\Actions\LoginUserAction;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Hedonist\Exceptions\Auth\PasswordResetEmailSentException;
use Hedonist\Exceptions\Auth\PasswordResetFailedException;
use Hedonist\Http\Controllers\Controller;
use Hedonist\Http\Requests\Auth\LoginHttpRequest;
use Hedonist\Http\Requests\Auth\RecoverPasswordHttpRequest;
use Hedonist\Http\Requests\Auth\RegisterHttpRequest;
use Hedonist\Http\Requests\Auth\ResetPasswordHttpRequest;
use Hedonist\Requests\Auth\RegisterRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(LoginHttpRequest $httpRequest, LoginUserAction $action)
    {
        try {
            $loginRequest = new LoginRequest($httpRequest->email, $httpRequest->password);
            $response = $action->execute($loginRequest);

            return response()->json(AuthPresenter::presentAuthenticateResponse($response), 200);
        } catch (AuthenticationException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        } catch (JWTException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        }
    }

    public function register(RegisterHttpRequest $httpRequset, RegisterUserAction $action)
    {
        try {
            $registerRequest = new RegisterRequest($httpRequset->email, $httpRequset->password, $httpRequset->name);
            $response = $action->execute($registerRequest);

            return response()->json(AuthPresenter::presentRegisterResponse($response), 200);
        } catch (EmailAlreadyExistsException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        } catch (JWTException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        } catch (\Exception $exception) {
            return response()->json(AuthPresenter::presentError($exception), 500);
        }
    }

    public function me(Request $request)
    {
        return response()->json(AuthPresenter::presentUser(Auth::user()), 200);
    }

    public function refresh()
    {
        return response()->json(AuthPresenter::presentAuthenticateResponse(
            new RefreshResponse(Auth::refresh())
        ));
    }

    public function resetPassword(ResetPasswordHttpRequest $httpRequest, ResetPasswordAction $action)
    {
        try {
            $resetRequest = new ResetPasswordRequest(
                $httpRequest->email,
                $httpRequest->password,
                $httpRequest->password_confirmation,
                $httpRequest->token);

            return response()->json(AuthPresenter::presentAuthenticateResponse(
                $action->execute($resetRequest)),
                200);
        } catch (JWTException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        } catch (PasswordResetFailedException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        }
    }

    public function recoverPassword(RecoverPasswordHttpRequest $httpRequest, RecoverPasswordAction $action)
    {
        try {
            $recoverRequest = new RecoverPasswordRequest($httpRequest->email);
            $action->execute($recoverRequest);

            return response()->json([], 200);
        } catch (PasswordResetEmailSentException $exception) {
            return response()->json(AuthPresenter::presentError($exception), 400);
        }
    }
}
