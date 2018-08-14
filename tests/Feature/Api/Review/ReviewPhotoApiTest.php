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
        Storage::fake('public');
        $file = UploadedFile::fake()->image('review.jpg');
        $review = factory(Review::class)->create();
        $response = $this->json('POST', '/api/v1/reviews/photos', [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => $file
        ]);
        $data = json_decode($response->getContent(), true);

        $response->assertHeader('Content-Type', 'application/json');
        $response->assertStatus(201);
        $this->assertDatabaseHas('review_photos', [
            'review_id' => $review->id,
            'description' => 'test',
            'img_url' => $data['data']['img_url'],
        ]);
        $arr = explode('/', $data['data']['img_url']);
        Storage::disk('public')->assertExists('upload/review/' . end($arr));
    }

    public function test_delete_review_photo()
    {
        $file = UploadedFile::fake()->image('review.jpg');
        Storage::disk('public')->put('upload/review', $file);
        $review = factory(Review::class)->create();
        $reviewPhoto = new ReviewPhoto();
        $reviewPhoto->review_id = $review->id;
        $reviewPhoto->description = 'test';
        $reviewPhoto->img_url = Storage::url('upload/review/' . $file->hashName());
        $reviewPhoto->save();

        $this->json('DELETE', "/api/v1/reviews/photos/" . $reviewPhoto->id);
        Storage::disk('public')->assertMissing('upload/review/' . $file->hashName());
    }
}