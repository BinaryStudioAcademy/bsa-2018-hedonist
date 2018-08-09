<?php

namespace Hedonist\Actions\SocialAuth\Manager;

use Hedonist\Actions\SocialAuth\Strategies\SocialAuthorizeStrategyInterface;

interface SocialAuthStrategyManagerInterface
{
    public function getStrategy(string $provider): SocialAuthorizeStrategyInterface;
}