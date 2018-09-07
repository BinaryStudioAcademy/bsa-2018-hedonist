<?php

namespace Tests\Feature\Api\UserFollows;

use Hedonist\Entities\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\ApiTestCase;

class UserFollowsTest extends ApiTestCase
{
    use RefreshDatabase;

    private $followed;
    private $follower;

    protected function setUp()
    {
        parent::setUp();

        $this->followed = factory(User::class)->create();
        $this->follower = factory(User::class)->create();

        $this->actingWithToken($this->follower);
    }

    public function test_follow_user_success()
    {
        $response = $this->json(
            'POST',
            '/api/v1/users/' . $this->followed->id . '/followers'
        );
        $response->assertStatus(200);

        $this->assertDatabaseHas('follows',
            [
                'followed_id' => $this->followed->id,
                'follower_id' => $this->follower->id
            ]
        );
    }

    public function test_follow_invalid_users()
    {
        $response = $this->json(
            'POST',
            '/api/v1/users/999999/followers'
        );
        $response->assertStatus(400);
    }

    public function test_follow_yourself()
    {
        $response = $this->actingAs($this->follower)
            ->json(
                'POST',
                '/api/v1/users/' . $this->follower->id . '/followers'
            );
        $response->assertStatus(400);
    }

    public function test_unfollow_user_success()
    {
        $this->followed->followers()->attach($this->follower);
        $response = $this->json(
            'DELETE',
            '/api/v1/users/' . $this->followed->id . '/followers'
        );
        $response->assertStatus(200);

        $this->assertDatabaseMissing('follows',
            [
                'followed_id' => $this->followed->id,
                'follower_id' => $this->follower->id
            ]
        );
    }

    public function test_unfollow_invalid_user()
    {
        $response = $this->json(
            'DELETE',
            '/api/v1/users/999999/followers'
        );
        $response->assertStatus(400);
    }

    public function test_get_followers()
    {
        $this->followed->followers()->attach($this->follower);
        $response = $this->json(
            'GET',
            '/api/v1/users/' . $this->followed->id . '/followers'
        );
        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json('data')));
    }

    public function test_get_followed_users()
    {
        $this->followed->followers()->attach($this->follower);
        $response = $this->json(
            'GET',
            '/api/v1/users/' . $this->follower->id . '/followed'
        );
        $response->assertStatus(200);

        $this->assertEquals(1, count($response->json('data')));
    }
}