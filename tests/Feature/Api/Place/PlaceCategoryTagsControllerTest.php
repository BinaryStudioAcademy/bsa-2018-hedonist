<?php

namespace Tests\Feature;

use Hedonist\Entities\User\User;
use Illuminate\Support\Facades\DB;
use Tests\Feature\Api\ApiTestCase;
use Hedonist\Entities\Place\PlaceCategory;
use Hedonist\Entities\Place\PlaceCategoryTag;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceCategoryTagsControllerTest extends ApiTestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingWithToken($this->user);
    }

    public function testGetTags()
    {
        $category = PlaceCategory::create([
            'name' => 'testCategory'
        ]);

        $tag = PlaceCategoryTag::create([
            'name' => 'testCategoryTag'
        ]);

        DB::table('place_category_place_tag')->insert([
            'place_category_id' => $category->id,
            'place_tag_id'      => $tag->id
        ]);

        $this->assertDatabaseHas('place_category_place_tag',
            [
                'place_category_id' => $category->id,
                'place_tag_id'      => $tag->id
            ]
        );


        $response = $this->json('GET',
            "/api/v1/places/categories/$category->id/tags");

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'place_category_id' => $category->id,
            'place_tag_id'      => $tag->id

        ]);
    }

    public function testGetTagsNoCategory()
    {
        $categoryId = 99999999;

        $this->assertDatabaseMissing('place_categories',
            [
                'id' => $categoryId
            ]
        );


        $response = $this->json('GET',
            "/api/v1/places/categories/$categoryId/tags");

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $response->assertExactJson([
            'data' => []
        ]);
    }

    public function testGetTagsNoTags()
    {
        $category = PlaceCategory::create([
            'name' => 'testCategory'
        ]);

        $this->assertDatabaseHas('place_categories',
            [
                'id' => $category->id,
            ]
        );


        $response = $this->json('GET',
            "/api/v1/places/categories/$category->id/tags");

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $response->assertExactJson([
            'data' => []
        ]);
    }
}
