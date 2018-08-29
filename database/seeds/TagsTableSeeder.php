<?php

use Illuminate\Database\Seeder;
use Hedonist\Entities\Place\Tag;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::query()->insert([
            [ 'name' => 'Ice-cream cafe' ],
            [ 'name' => 'Cafe-confectionery' ],
            [ 'name' => 'Children\'s cafe' ],
            [ 'name' => 'Family cafe' ],
            [ 'name' => 'Internet cafe' ],
            [ 'name' => 'Youth cafe' ],
            [ 'name' => 'Coffee Room' ],
            [ 'name' => 'Tea Room' ],
            [ 'name' => 'Brewery' ],
            [ 'name' => 'Kneipp' ],
            [ 'name' => 'Gastropub' ],
            [ 'name' => 'Pub' ],
            [ 'name' => 'Irish Pub' ],
            [ 'name' => 'Beer pub' ],
            [ 'name' => 'Pizzeria' ],
            [ 'name' => 'Food Court' ],
            [ 'name' => 'Italian restaurant' ],
            [ 'name' => 'Vegan Restaurant' ],
            [ 'name' => 'European restaurant' ],
            [ 'name' => 'West-Ukrainian Restaurant' ],
            [ 'name' => 'French Restaurant' ],
            [ 'name' => 'Ukrainian Restaurant' ],
            [ 'name' => 'Asian Restaurant' ],
            [ 'name' => 'Vietnamese Restaurant' ],
            [ 'name' => 'Steak House' ],
            [ 'name' => 'Milk bar' ],
            [ 'name' => 'Cocktail bar' ],
            [ 'name' => 'Whiskey bar' ],
            [ 'name' => 'Wine bar' ],
            [ 'name' => 'Sushi Bar' ],
            [ 'name' => 'Snack bar with burgers' ],
            [ 'name' => 'Snack bar with burrito' ],
            [ 'name' => 'Snack with hot dogs' ],
            [ 'name' => 'Snack with dumplings' ],
            [ 'name' => 'Snack with pancake' ],
            [ 'name' => 'Sweet shop' ],
            [ 'name' => 'Chocolate shop' ],
            [ 'name' => 'Confectionery' ],
        ]);
    }
}
