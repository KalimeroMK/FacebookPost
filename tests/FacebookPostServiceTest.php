<?php

namespace Kalimeromk\FacebookPost\Tests;

use Illuminate\Support\Facades\Http;
use Kalimeromk\FacebookPost\Facades\FacebookPost;
use Orchestra\Testbench\TestCase;

class FacebookPostServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_can_create_a_text_post()
    {
        Http::fake([
            'https://graph.facebook.com/v22.0/*' => Http::response(['id' => '123456789'], 200),
        ]);

        $response = FacebookPost::storePost('Test message');

        $this->assertIsArray($response);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('Post created successfully', $response['message']);
        $this->assertEquals('123456789', $response['post_id']);
    }

    public function test_it_can_create_a_photo_post()
    {
        Http::fake([
            'https://graph.facebook.com/v22.0/*' => Http::response(['post_id' => '987654321'], 200),
        ]);

        $response = FacebookPost::storePostWithPhoto('https://example.com/photo.jpg', 'Photo caption');

        $this->assertIsArray($response);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('Photo post created successfully', $response['message']);
        $this->assertEquals('987654321', $response['post_id']);
    }

    public function test_it_can_create_a_video_post()
    {
        Http::fake([
            'https://graph.facebook.com/v22.0/*' => Http::response(['id' => '555555555'], 200),
        ]);

        $response = FacebookPost::storePostWithVideo('https://example.com/video.mp4', 'Video Title', 'Video Description');

        $this->assertIsArray($response);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('Video post created successfully', $response['message']);
        $this->assertEquals('555555555', $response['post_id']);
    }


    public function test_it_can_update_a_post()
    {
        Http::fake([
            'https://graph.facebook.com/v22.0/*' => Http::response([], 200),
        ]);

        $response = FacebookPost::updatePost('123456789', 'Updated message');

        $this->assertIsArray($response);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('Post updated successfully', $response['message']);
        $this->assertEquals('123456789', $response['post_id']);
    }

    public function test_it_can_delete_a_post()
    {
        Http::fake([
            'https://graph.facebook.com/v22.0/*' => Http::response([], 200),
        ]);

        $response = FacebookPost::deletePost('123456789');

        $this->assertIsArray($response);
        $this->assertEquals('success', $response['status']);
        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('Post deleted successfully', $response['message']);
        $this->assertEquals('123456789', $response['post_id']);
    }
}
