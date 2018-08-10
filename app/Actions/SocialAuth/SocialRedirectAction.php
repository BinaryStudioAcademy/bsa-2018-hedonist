<?php

namespace Hedonist\Actions\SocialAuth;

use Hedonist\Actions\SocialAuth\Requests\SocialRequest;
use Hedonist\Actions\SocialAuth\Responses\SocialRedirectResponse;
use Hedonist\Exceptions\Auth\InvalidSocialProviderException;
use Laravel\Socialite\Facades\Socialite;

class SocialRedirectAction
{
    public function execute(SocialRequest $request): SocialRedirectResponse
    {
        try {
            $redirect = Socialite::with($request->getProvider())->stateless()->redirect();

            return new SocialRedirectResponse($redirect->getTargetUrl());
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidSocialProviderException();
        }
    }
}