<?php

namespace Hedonist\Actions\SocialAuth\Responses;

class SocialRedirectResponse
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl():string
    {
        return $this->url;
    }
}