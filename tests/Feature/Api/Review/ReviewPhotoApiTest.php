<?php

namespace Tests\Feature;

use Hedonist\Entities\Review\ReviewPhoto;
use Hedonist\Entities\Review\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Api\ApiTestCase;
use Tests\JwtTestCase;

class ReviewPhotoApiTest extends ApiTestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->actingWithToken();
    }

    public function test_review_photo_add()
    {
        Storage::fake('review-photos');

        $file = UploadedFile::fake()->image('review.jpg');
        $review = factory(Review::class)->create();


        $response = $this->json('POST', '/api/v1/review-photo', [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => $file
        ]);
        $data = json_decode($response->getContent(),true);

        $response->assertHeader('Content-Type', 'application/json');
        $this->assertDatabaseHas('review_photos', [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => $data['data']['img_url'],
        ]);
        Storage::disk('review-photos')->assertExists($data['data']['img_url']);
    }

    public function test_delete_review_photo()
    {
        Storage::fake('review-photos');

        $file = UploadedFile::fake()->image('review.jpg');
        $review = factory(Review::class)->create();


        $response = $this->json('POST', '/api/v1/review-photo', [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => $file
        ]);
        $data = json_decode($response->getContent(),true);

        $response->assertHeader('Content-Type', 'application/json');
        $this->assertDatabaseHas('review_photos', [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => $data['data']['img_url'],
        ]);
        Storage::disk('review-photos')->assertExists($data['data']['img_url']);

        $this->json('DELETE',"/api/v1/review-photo/" . $data['data']['id']);
        Storage::disk('review_photos')->assertMissing($data['data']['img_url']);
    }
}