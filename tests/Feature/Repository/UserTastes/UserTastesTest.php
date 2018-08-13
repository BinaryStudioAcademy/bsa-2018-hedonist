<?php

namespace Tests\Feature\Repository\UserTastesTest;

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\Taste;
use Hedonist\Repositories\User\TasteRepository;
use Hedonist\Repositories\User\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTastesTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $userRepo;
    private $tasteRepo;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->userRepo = new UserRepository(app());
        $this->tasteRepo = new TasteRepository(app());
    }

    public function test_relation()
    {
        $taste = factory(Taste::class)->make();
        $this->user->tastes()->save($taste);

        $this->assertDatabaseHas(
            'taste_user',
            ['user_id' => $this->user->id, 'taste_id' => $taste->id]
        );
    }

    public function test_set_taste()
    {
        $tastes = factory(Taste::class, 3)->make();
        $tastes->each(function ($item) {
            $this->tasteRepo->save($item);
        });

        $this->assertEquals($tastes->count(), $this->tasteRepo->findAll()->count());
        $this->userRepo->setTastes($this->user, $tastes);
        $this->assertEquals($tastes->count(), $this->tasteRepo->findByUser($this->user->id)->count());
    }

    public function test_add_taste()
    {
        $taste = factory(Taste::class)->make();
        $this->user->tastes()->save($taste);
        $tasteToAdd = factory(Taste::class)->create();
        $this->userRepo->addTaste($this->user, $tasteToAdd);
        $this->assertEquals(2, $this->tasteRepo->findByUser($this->user->id)->count());
    }

    public function test_delete_taste()
    {
        $taste = factory(Taste::class, 2)->make();
        $this->user->tastes()->saveMany($taste);
        $this->userRepo->deleteTaste($this->user, $taste[0]);
        $this->assertEquals(1, $this->tasteRepo->findByUser($this->user->id)->count());
    }
}