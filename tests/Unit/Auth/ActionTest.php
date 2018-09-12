<?php

namespace Tests\Unit\Auth;

use Hedonist\Actions\Auth\RegisterUserAction;
use Hedonist\Actions\Auth\Requests\LoginRequest;
use Hedonist\Actions\Auth\Requests\ResetPasswordRequest;
use Hedonist\Actions\Auth\ResetPasswordAction;
use Hedonist\Actions\LoginUserAction;
use Hedonist\Entities\User\User;
use Hedonist\Exceptions\Auth\EmailAlreadyExistsException;
use Hedonist\Exceptions\Auth\PasswordResetFailedException;
use Hedonist\Repositories\User\UserInfoRepositoryInterface;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Requests\Auth\RegisterRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

//No recover action test, since it simply calls PasswordBroker method
class ActionTest extends TestCase
{
    private $repository;
    private $broker;
    private $infoRepository;

    protected function setUp()
    {
        parent::setUp();

        $this->repository = $this->createMock(UserRepositoryInterface::class);
        $this->infoRepository = $this->createMock(UserInfoRepositoryInterface::class);
        $this->broker = $this->createMock(PasswordBroker::class);
    }

    public function test_success_register()
    {
        Event::fake();

        $this->repository->method('getByEmail')->willReturn(null);
        $this->repository
            ->expects($this->once())
            ->method('save')
            ->willReturn(factory(User::class)->make());

        $request = new RegisterRequest('abcd@gamil.com', '123', 'Test', 'Test', 'ua');
        $action = new RegisterUserAction($this->repository, $this->infoRepository);
        $action->execute($request);

        Event::assertDispatched(Registered::class, 1);
    }

    public function test_email_in_use()
    {
        $this->repository->method('getByEmail')->willReturn(new User());

        $this->expectException(EmailAlreadyExistsException::class);

        $request = new RegisterRequest('abcd@gamil.com', '123', 'Test', 'Test', 'ua');
        $action = new RegisterUserAction($this->repository, $this->infoRepository);
        $action->execute($request);
    }

    public function test_success_login()
    {
        $token = str_random(30);
        Auth::shouldReceive('attempt')->andReturn($token);

        $request = new LoginRequest('a@b.com', 'secret');
        $action = new LoginUserAction();
        $response = $action->execute($request);

        $this->assertEquals($response->getToken(), $token);
    }

    public function test_fail_login()
    {
        Auth::shouldReceive('attempt')->andReturn(null);

        $this->expectException(AuthenticationException::class);

        $request = new LoginRequest('a@b.com', 'secret');
        $action = new LoginUserAction();
        $action->execute($request);
    }


    public function test_reset()
    {
        $token = str_random(30);
        Auth::shouldReceive('login')->andReturn($token);

        $this->broker->method('reset')->will($this->returnCallback(function ($data, $cb) {
            $cb(factory(User::class)->make(), 'secret');
            return Password::PASSWORD_RESET;
        }));

        $action = new ResetPasswordAction($this->repository, $this->broker);
        $request = new ResetPasswordRequest(
            'email',
            'secret',
            'secret',
            'token'
        );
        $response = $action->execute($request);

        $this->assertEquals($response->getToken(), $token);
    }

    public function test_reset_failed()
    {
        $this->expectException(PasswordResetFailedException::class);

        $this->broker->method('reset')->will($this->returnCallback(
            function ($data, $cb) {
                return Password::INVALID_TOKEN;
            })
        );

        $action = new ResetPasswordAction($this->repository, $this->broker);
        $request = new ResetPasswordRequest(
            'email',
            'secret',
            'secret',
            'token'
        );
        $action->execute($request);
    }
}