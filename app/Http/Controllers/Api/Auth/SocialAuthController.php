<?php

namespace Hedonist\Http\Controllers\Api\Auth;


use Hedonist\Actions\Auth\Presenters\AuthPresenter;
use Hedonist\Actions\SocialAuth\Requests\SocialRequest;
use Hedonist\Actions\SocialAuth\SocialAuthorizeAction;
use Hedonist\Actions\SocialAuth\SocialRedirectAction;
use Hedonist\Exceptions\Auth\InvalidSocialProviderException;
use Hedonist\Http\Controllers\Api\ApiController;

class SocialAuthController extends ApiController
{
    public function redirect(string $provider, SocialRedirectAction $action)
    {
        try {
            $request = new SocialRequest($provider);
            $response = $action->execute($request);

            return $this->successResponse(AuthPresenter::presentSocialRedirect($response));
        } catch (InvalidSocialProviderException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        } catch (\Exception $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 500);
        }
    }

    public function callback(string $provider, SocialAuthorizeAction $action)
    {
        try {
            $request = new SocialRequest($provider);
            $response = $action->execute($request);

            return $this->successResponse(AuthPresenter::presentAuthenticateResponse($response));
        } catch (InvalidSocialProviderException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 400);
        } catch (\DomainException $exception) {
            return $this->errorResponse(AuthPresenter::presentError($exception), 500);
        }
    }
}