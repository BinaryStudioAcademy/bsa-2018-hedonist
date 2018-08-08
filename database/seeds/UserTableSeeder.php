<?php

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    private const ENTITY_COUNT = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, self::ENTITY_COUNT)->create();
        foreach ($users as $user) {
            factory(UserInfo::class)->create([
                'user_id' => $user->id
            ]);
        }
    }
}
