<?php

namespace Hedonist\Http\Controllers\Api\Auth;

use Hedonist\Actions\Auth\ChangePasswordAction;
use Hedonist\Actions\Auth\CheckEmailUniqueAction;
use Hedonist\Actions\Auth\GetUserAction;
use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Hedonist\Actions\Auth\RecoverPasswordAction;
use Hedonist\Actions\Auth\RegisterUserAction;
use Hedonist\Actions\Auth\Requests\ChangePasswordRequest;
use Hedonist\Actions\Auth\Requests\CheckEmailUniqueRequest;
use Hedonist\Actions\Auth\Requests\GetUserRequest;
use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Requests\RecoverPasswordRequest;
use Hedonist\Actions\Auth\Requests\ResetPasswordRequest;
use Hedonist\Actions\Auth\ResetPasswordAction;
use Hedonist\Actions\Auth\Responses\RefreshResponse;
use Hedonist\Actions\LoginUserAction;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Hedonist\Exceptions\Auth\InvalidUserDataException;
use Hedonist\Exceptions\Auth\PasswordResetEmailSentException;
use Hedonist\Exceptions\Auth\PasswordResetFailedException;
use Hedonist\Exceptions\Auth\PasswordsDosentMatchException;
use Hedonist\Http\Controllers\Api\ApiController;
use Hedonist\Http\Requests\Auth\ChangePasswordHttpRequest;
use Hedonist\Http\Requests\Auth\CheckEmailUniqueHttpRequest;
use Hedonist\Http\Requests\Auth\LoginHttpRequest;
use Hedonist\Http\Requests\Auth\RecoverPasswordHttpRequest;
use Hedonist\Http\Requests\Auth\RegisterHttpRequest;
use Hedonist\Http\Requests\Auth\ResetPasswordHttpRequest;
use Hedonist\Requests\Auth\RegisterRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends ApiController
{
    public function login(LoginHttpRequest $httpRequest, LoginUserAction $action)
    {
        try {
            $loginRequest = new LoginRequest($httpRequest->email, $httpRequest->password);
            $response = $action->execute($loginRequest);

            return $this->successResponse(AuthPresenter::presentAuthenticateResponse($response));
        } catch (AuthenticationException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        } catch (JWTException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        }
    }

    public function register(RegisterHttpRequest $httpRequset, RegisterUserAction $action)
    {
        try {
            $registerRequest = new RegisterRequest(
                $httpRequset->email,
                $httpRequset->password,
                $httpRequset->last_name,
                $httpRequset->first_name
            );
            $action->execute($registerRequest);

            return $this->emptyResponse(200);
        } catch (EmailAlreadyExistsException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        } catch (JWTException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        } catch (\Exception $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 500);
        }
    }

    public function me(GetUserAction $action)
    {
        try {
            $response = $action->execute(new GetUserRequest(Auth::id()));

            return $this->successResponse(AuthPresenter::presentUser($response));
        } catch (InvalidUserDataException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        }
    }

    public function refresh()
    {
        try {
            return $this->successResponse(
                AuthPresenter::presentAuthenticateResponse(
                    new RefreshResponse(Auth::refresh())
                )
            );
        } catch (JWTException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 401);
        } catch (\Exception $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 500);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();

            return $this->emptyResponse(200);
        } catch (\Exception $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        }
    }

    public function resetPassword(ResetPasswordHttpRequest $httpRequest, ResetPasswordAction $action)
    {
        try {
            $resetRequest = new ResetPasswordRequest(
                $httpRequest->email,
                $httpRequest->password,
                $httpRequest->password_confirmation,
                $httpRequest->token);

            return $this->successResponse(
                AuthPresenter::presentAuthenticateResponse($action->execute($resetRequest))
            );
        } catch (JWTException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        } catch (PasswordResetFailedException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        }
    }

    public function recoverPassword(RecoverPasswordHttpRequest $httpRequest, RecoverPasswordAction $action)
    {
        try {
            $recoverRequest = new RecoverPasswordRequest($httpRequest->email);
            $action->execute($recoverRequest);

            return $this->emptyResponse(200);
        } catch (PasswordResetEmailSentException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        }
    }

    public function changePassword(ChangePasswordHttpRequest $httpRequest, ChangePasswordAction $action)
    {
        try {
            $changeRequest = new ChangePasswordRequest($httpRequest->old_password, $httpRequest->new_password);
            $action->execute($changeRequest);

            return $this->emptyResponse(200);
        } catch (PasswordsDosentMatchException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        }
    }

    public function checkEmailUnique(CheckEmailUniqueHttpRequest $httpRequest, CheckEmailUniqueAction $action) : JsonResponse
    {
        try {
            $checkEmailUniqueRequest = new CheckEmailUniqueRequest($httpRequest->email);
            $response = $action->execute($checkEmailUniqueRequest);

            return $this->successResponse([
                'email' => $response->getEmail(),
                'isUnique' => $response->isUnique(),
            ], 201);
        } catch (\LogicException $ex) {
            return $this->errorResponse($ex->getMessage(), 400);
        }
    }
}