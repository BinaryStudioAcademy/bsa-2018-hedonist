<?php

namespace Hedonist\Actions\Auth\Responses;

class CheckEmailUniqueResponse
{
    private $isUnique;
    private $email;

    public function __construct(bool $isUnique, string $email)
    {
        $this->isUnique = $isUnique;
        $this->email = $email;
    }

    public function isUnique(): bool
    {
        return $this->isUnique;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}