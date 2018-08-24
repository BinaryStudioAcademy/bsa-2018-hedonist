<?php

namespace Hedonist\Actions\SocialAuth\Requests;

class SocialRequest
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