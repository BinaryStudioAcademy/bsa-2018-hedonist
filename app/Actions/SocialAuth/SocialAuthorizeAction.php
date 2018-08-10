<?php

namespace Hedonist\Actions\SocialAuth;

use Hedonist\Actions\SocialAuth\Manager\SocialAuthStrategyManagerInterface;
use Hedonist\Actions\SocialAuth\Requests\SocialRequest;
use Hedonist\Actions\SocialAuth\Responses\SocialAuthorizeResponse;
use Hedonist\Exceptions\Auth\InvalidSocialProviderException;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthorizeAction
{
    private $manager;

    public function __construct(SocialAuthStrategyManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function execute(SocialRequest $request): SocialAuthorizeResponse
    {
        try {
            $socialUser = Socialite::driver($request->getProvider())->user;
            $strategy = $this->manager->getStrategy($request->getProvider());
            $token = $strategy->authorize($socialUser);

            return new SocialAuthorizeResponse($token);
        } catch (\InvalidArgumentException $exception) {
            throw new InvalidSocialProviderException();
        }
    }
}