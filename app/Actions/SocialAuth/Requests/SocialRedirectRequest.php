<?php

namespace Hedonist\Actions\SocialAuth\Requests;

class SocialRedirectRequest
{
    private $provider;

    public function __construct(string $provider)
    {
        $this->provider = $provider;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }
}