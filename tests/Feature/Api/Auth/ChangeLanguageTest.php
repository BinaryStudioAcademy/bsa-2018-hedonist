<?php

namespace Tests\Feature\Api\Auth;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;
use Tests\TestCase;

class ChangeLanguageTest extends ApiTestCase
{
    use RefreshDatabase;

    private $user;
    private $userInfo;

    protected function setUp()
    {
        parent::setUp();

        $this->user     = factory(User::class)->create();
        $this->userInfo = factory(UserInfo::class)->create();
    }

    public function test_change_language_success()
    {
        $this->authenticate($this->user);
        factory(UserInfo::class)->create(['user_id' => $this->user->id]);
        $language = 'ua';

        $response = $this->json('POST',
            'api/v1/auth/language',
            [
                'user_id'  => $this->user->id,
                'language' => $language
            ]);

        $response->assertStatus(200);

        $response = $this->json('GET', 'api/v1/auth/me');

        $this->assertEquals($language, $response->original['data']['language']);
    }

    public function test_change_language_fail()
    {
        $this->authenticate($this->user);

        $response = $this->json('POST',
            'api/v1/auth/language',
            [
                'user_id'  => $this->user->id,
                'language' => 'zz'
            ]);

        $response->assertStatus(400);
    }
}
