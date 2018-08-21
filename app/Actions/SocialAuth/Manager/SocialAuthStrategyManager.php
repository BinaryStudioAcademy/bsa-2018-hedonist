<?php

namespace Hedonist\Actions\SocialAuth\Manager;

use Hedonist\Actions\SocialAuth\Strategies\FacebookAuthorizeStrategy;
use Hedonist\Actions\SocialAuth\Strategies\SocialAuthorizeStrategyInterface;
use Illuminate\Support\Facades\App;

class SocialAuthStrategyManager implements SocialAuthStrategyManagerInterface
{
    public function getStrategy(string $provider): SocialAuthorizeStrategyInterface
    {
        switch ($provider) {
            case 'facebook':
                return App::make(FacebookAuthorizeStrategy::class);
        }
    }
}