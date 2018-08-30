<?php

namespace Tests\Feature\Api\UserTaste;

use Hedonist\Entities\User\CustomTaste;
use Hedonist\Entities\User\User;
use Hedonist\Entities\User\Taste;
use Tests\Feature\Api\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasteTest extends ApiTestCase
{
    use RefreshDatabase;
    
    private $token;
    private $user;
   
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->create();
        $this->token = \JWTAuth::fromUser($this->user);
    }
    
    public function test_get_user_tastes_not_authorize()
    {
        $response = $this->json('GET', '/api/v1/tastes');
        $response->assertStatus(401);
    }
    
    public function test_get_tastes()
    {
        factory(Taste::class, 3)->create();
        
        $response = $this->json('GET', '/api/v1/tastes', [], ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertHeader('Content-Type', 'application/json')
                    ->assertJsonCount(3, 'data')
                    ->assertOk();
    }

    public function test_add_custom_taste()
    {
        $response = $this->actingWithToken()->post(
            "/api/v1/tastes/custom", [
                'name' => 'Custom taste'
            ]
        );
        $response->assertStatus(201);
        $this->assertDatabaseHas('custom_tastes', [
            'name' => 'Custom taste'
        ]);
    }

    public function test_delete_custom_taste()
    {
        $customTaste = factory(CustomTaste::class)->create();
        $response = $this->actingWithToken(User::find($customTaste->user_id))
            ->delete("/api/v1/tastes/custom/$customTaste->id");
        $response->assertOk();
        $this->assertDatabaseMissing('custom_tastes', [
            'name' => $customTaste->id
        ]);
    }
}