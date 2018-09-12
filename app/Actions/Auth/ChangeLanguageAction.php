<?php

namespace Hedonist\Actions\Auth;

use Hedonist\Actions\Auth\Requests\ChangeLanguageRequest;
use Hedonist\Entities\User\UserInfo;
use Hedonist\Exceptions\Auth\InvalidLanguageException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;

class ChangeLanguageAction
{
    const ALLOWED_LANGUAGES = ['en', 'ua', 'ru'];
    
    private $repository;

    public function __construct(UserInfoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ChangeLanguageRequest $request): void
    {
        $language = $request->getLanguage();
        if (array_search($language, self::ALLOWED_LANGUAGES) === false) {
            throw new InvalidLanguageException();
        }
        $userInfo = $this->repository->getByUserId($request->getUserId());
        $userInfo->language = $language;
        $this->repository->save($userInfo);
    }
}
