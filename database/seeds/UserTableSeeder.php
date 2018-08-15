<?php

use Hedonist\Entities\User\User;
use Hedonist\Entities\User\UserInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserInfo::create([
            'user_id' => factory(User::class)->create([
                'email' => 'vladimir.kudinov@gmail.com'
            ])->id,
            'first_name' => 'Vladimir',
            'last_name' => 'Kudinov',
            'date_of_birth' => '1986-10-11',
            'phone_number' => '+380999192991',
            'avatar_url' => 'https://instagram.fhrk1-1.fna.fbcdn.net/vp/f9472104c184408f7e566fce7942d9b3/5BFFDA1C/t51.2885-19/s150x150/18644930_364022684000162_4610752073493905408_a.jpg',
            'facebook_url' => 'https://www.facebook.com/vladimir.kudinov.madbyte?ref=br_rs',
            'instagram_url' => 'https://www.instagram.com/madbyte/',
            'twitter_url' => 'https://twitter.com/stsilent',
        ]);
        UserInfo::create([
            'user_id' => factory(User::class)->create([
                'email' => 'yury.dud@gmail.com'
            ])->id,
            'first_name' => 'Yury',
            'last_name' => 'Dud',
            'date_of_birth' => '1975-11-22',
            'phone_number' => '+80935789425',
            'avatar_url' => 'https://24smi.org/public/media/2017/9/15/06_HtY6VxA.jpg',
            'facebook_url' => 'https://www.facebook.com/yury.dud',
            'instagram_url' => 'https://www.instagram.com/yurydud/?hl=ru',
            'twitter_url' => 'https://twitter.com/yurydud',
        ]);
        UserInfo::create([
            'user_id' => factory(User::class)->create([
                'email' => 'alex.fiannaca@gmail.com'
            ])->id,
            'first_name' => 'Alex ',
            'last_name' => 'Fiannaca',
            'date_of_birth' => '1982-01-09',
            'phone_number' => '+809554486546',
            'avatar_url' => 'https://www.microsoft.com/en-us/research/uploads/prod/2018/02/ProfilePhoto.jpg',
            'facebook_url' => 'https://www.facebook.com/fiannaca?ref=br_rs',
            'instagram_url' => 'https://www.instagram.com/fiannac4/',
            'twitter_url' => 'https://twitter.com/fiannac4',
        ]);
    }
}
