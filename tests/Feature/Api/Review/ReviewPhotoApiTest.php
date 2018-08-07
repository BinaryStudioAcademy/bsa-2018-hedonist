<?php

namespace Tests\Feature;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\JwtTestCase;

class ReviewPhotoApiTest extends JwtTestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->actingAsJwtToken();
    }

    public function test_add_user_list()
    {
        $review = factory(Review::class)->create();
        $data = [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => 'http://test.image',
        ];
        $response = $this->json('POST','/api/v1/review-photo', $data);
        $response->assertHeader('Content-Type', 'application/json');

        $this->assertDatabaseHas('review_photos', $data);
    }

    public function test_get_user_list()
    {
        $reviewPhoto = factory(ReviewPhoto::class)->create();
        $response = $this->json('GET',"/api/v1/review-photo/$reviewPhoto->id");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(),true);
        $this->assertEquals($reviewPhoto->id, $data['data']['id']);
        $this->assertEquals($reviewPhoto->review_id, $data['data']['review_id']);
        $this->assertEquals($reviewPhoto->description, $data['data']['description']);
        $this->assertEquals($reviewPhoto->img_url, $data['data']['img_url']);
    }

    public function test_update_user_list()
    {
        $reviewPhoto = factory(ReviewPhoto::class)->create();
        $data = [
            'review_id' => $reviewPhoto->review_id,
            'description' => 'test',
            'img_url' => 'http://test.image',
        ];
        $response = $this->json('PUT',"/api/v1/review-photo/$reviewPhoto->id", $data);
        $result = json_decode($response->getContent(),true);
        $this->assertEquals($result['data']['description'], $data['description']);
    }

    public function test_delete_user_list()
    {
        $reviewPhoto = factory(ReviewPhoto::class)->create();
        $this->json('DELETE',"/api/v1/review-photo/$reviewPhoto->id");

        $this->json('GET', "/api/v1/review-photo/$reviewPhoto->id")->assertStatus(404);
    }

    public function test_get_all_user_list()
    {
        $reviewPhotos = [];
        for ($i = 0; $i < 3; $i++) {
            $reviewPhotos[] = factory(ReviewPhoto::class)->create();
        }

        $response = $this->json('GET',"/api/v1/review-photo");
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(),true);
        $this->assertEquals(count($data['data']), count($reviewPhotos));
    }

    public function test_get_user_list_not_found()
    {
        $this->json('GET', "/api/v1/review-photo/1")->assertStatus(404);
    }
}