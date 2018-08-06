<?php

namespace Tests\Feature\Api;

class LikeReviewApiTest extends ApiTestCase
{
    public function testLikeReviewNotFound()
    {
        $response = $this->post('/api/v1/reviews/99999/like');
        $response->assertNotFound();
    }
}