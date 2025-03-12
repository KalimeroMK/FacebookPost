<?php

namespace Kalimeromk\FacebookPost\Services;

use Illuminate\Support\Facades\Http;
use Kalimeromk\FacebookPost\Traits\Helper;

class FacebookPostService
{
    use Helper;

    public function __construct()
    {
        $this->page_id = config('facebook.page_id','10160837575386795');
        $this->access_token = config('facebook.access_token','EAAM4C5Pxa5kBOzerqkdVcybvj0zkrUdCSRk1tyxAZAoEgpCZAyrFZB9ZAaR1F4DeJqn6GYs8HmMLUJO1oqNIFXnLZCxn4CxHbh10YY4GZBAdGhg3X9mS7AqMB21ULslietxK6IIevKMRWSaRUtamIGSwkVROhQUsif6lyzawaj6Dv7VlM0IZAJQdk4oG9VKi0RxtsyxAUZCQMPDd9ad1z3itGlLr');
    }

    /**
     * Get posts from the Facebook page.
     */
    public function getPosts(): array
    {
        $url = "https://graph.facebook.com/v22.0/{$this->page_id}/feed";

        $response = Http::get($url, [
            'access_token' => $this->access_token,
        ]);

        return $response->successful() ? $response->json() : $this->failureResponse($response->status(), $response->body());
    }

    /**
     * Create a new Facebook post.
     */
    public function storePost(string $message): array
    {
        if (empty($message)) {
            return $this->failureResponse(422, 'Message is required');
        }

        $url = "https://graph.facebook.com/v22.0/{$this->page_id}/feed";

        $response = Http::post($url, [
            'message' => $message,
            'access_token' => $this->access_token,
        ]);

        return $response->successful()
            ? $this->successResponse('Post created successfully', $response->json()['id'])
            : $this->failureResponse($response->status(), $response->body());
    }

    /**
     * Create a post with a photo.
     */
    public function storePostWithPhoto(string $imageUrl, ?string $message = null): array
    {
        if (empty($imageUrl)) {
            return $this->failureResponse(422, 'Image URL is required');
        }

        $url = "https://graph.facebook.com/v22.0/{$this->page_id}/photos";

        $response = Http::post($url, [
            'url' => $imageUrl,
            'message' => $message,
            'access_token' => $this->access_token,
        ]);

        return $response->successful()
            ? $this->successResponse('Photo post created successfully', $response->json()['post_id'] ?? null)
            : $this->failureResponse($response->status(), $response->body());
    }

    /**
     * Create a post with a video.
     */
    public function storePostWithVideo(string $videoUrl, ?string $title = '', ?string $description = ''): array
    {
        if (empty($videoUrl)) {
            return $this->failureResponse(422, 'Video URL is required');
        }

        $url = "https://graph.facebook.com/v22.0/{$this->page_id}/videos";

        $response = Http::post($url, [
            'file_url' => $videoUrl,
            'title' => $title,
            'description' => $description,
            'access_token' => $this->access_token,
        ]);

        return $response->successful()
            ? $this->successResponse('Video post created successfully', $response->json()['id'] ?? null)
            : $this->failureResponse($response->status(), $response->body());
    }

    /**
     * Update an existing Facebook post.
     */
    public function updatePost(string $post_id, string $message): array
    {
        if (empty($post_id) || empty($message)) {
            return $this->failureResponse(422, 'Post ID and message are required');
        }

        if (!$this->checkID($post_id)) {
            return $this->failureResponse(422, 'Invalid Post ID');
        }

        $url = "https://graph.facebook.com/v22.0/{$post_id}";

        $response = Http::post($url, [
            'message' => $message,
            'access_token' => $this->access_token,
        ]);

        return $response->successful()
            ? $this->successResponse('Post updated successfully', $post_id)
            : $this->failureResponse($response->status(), $response->body());
    }

    /**
     * Delete a Facebook post.
     */
    public function deletePost(string $post_id): array
    {
        if (empty($post_id)) {
            return $this->failureResponse(422, 'Post ID is required');
        }

        if (!$this->checkID($post_id)) {
            return $this->failureResponse(422, 'Invalid Post ID');
        }

        $url = "https://graph.facebook.com/v22.0/{$post_id}";

        $response = Http::delete($url, [
            'access_token' => $this->access_token,
        ]);

        return $response->successful()
            ? $this->successResponse('Post deleted successfully', $post_id)
            : $this->failureResponse($response->status(), $response->body());
    }
}
