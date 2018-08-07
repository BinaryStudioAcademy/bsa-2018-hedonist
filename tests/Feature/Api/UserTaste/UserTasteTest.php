<?php

namespace Tests\Feature\Api\UserTaste;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\Taste;
use Tests\Feature\Api\ApiTestCase;

class UserTasteTest extends ApiTestCase
{
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
        $response = $this->json('GET','/api/v1/user/tastes');
        $response->assertStatus(401);
    }
    public function test_get_user_tastes()
    {
        $tastes = factory(Taste::class,3)->create()->each(function ($taste) {
            $this->user->tastes()->save($taste);
        });
        $response = $this->json('GET','/api/v1/user/tastes', [], ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertHeader('Content-Type', 'application/json')
                    ->assertJsonCount(3,'data')
                    ->assertOk();
    }
  
    public function test_user_add_taste() {
        $taste = factory(Taste::class)->create();
        $response = $this->json('POST', '/api/v1/user/tastes', ['taste_id' => $taste['id']], ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertHeader('Content-Type', 'application/json')
                    ->assertStatus(201);
    }
    
    public function test_user_add_nonexistent_taste() {
      
        $response = $this->json('POST', '/api/v1/user/tastes', ['taste_id' => 12345], ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertHeader('Content-Type', 'application/json')
                    ->assertNotFound();
    }
    public function test_user_delete_taste() {
        $taste = factory(Taste::class)->create();
        $this->user->tastes()->save($taste);
      
        $this->assertDatabaseHas('taste_user', [
            'user_id' => $this->user->id,
            'taste_id' => $taste->id
        ]);
        $response = $this->json('DELETE', "/api/v1/user/tastes/$taste->id",[], ['Authorization' => 'Bearer ' . $this->token]);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('taste_user', [
            'user_id' => $this->user->id,
            'taste_id' => $taste->id
                ]
        );
    }

}
