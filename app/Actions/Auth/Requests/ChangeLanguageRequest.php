<?php

namespace Hedonist\Actions\Auth\Requests;

class ChangeLanguageRequest
{
    private $userId;
    private $language;

    public function __construct(int $userId, string $language)
    {
        $this->userId   = $userId;
        $this->language = $language;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    
    public function getLanguage(): string
    {
        return $this->language;
    }
}
