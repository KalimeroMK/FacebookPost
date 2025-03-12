<?php

namespace Kalimeromk\FacebookPost\Traits;

trait Helper
{
    protected string $page_id;
    protected string $access_token;

    /**
     * Validate if the given ID is a valid string.
     */
    public function checkID($id): bool
    {
        return is_string($id);
    }

    /**
     * Success response format.
     */
    public function successResponse(string $message, ?string $post_id = null): array
    {
        return [
            'status' => 'success',
            'status_code' => 200,
            'message' => $message,
            'post_id' => $post_id,
        ];
    }

    /**
     * Failure response format.
     */
    public function failureResponse(int $code, string $message): array
    {
        return [
            'status' => 'fail',
            'status_code' => $code,
            'message' => $message,
        ];
    }
}
