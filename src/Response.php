<?php

namespace Swiftsms;

/**
 * Response Data Transfer Object
 *
 * Provides typed access to API responses
 */
class Response
{
    public string $status;
    public ?string $message;
    public ?int $code;
    public mixed $data;
    public array $raw;

    public function __construct(array $response)
    {
        $this->raw = $response;
        $this->status = $response['status'] ?? 'unknown';
        $this->message = $response['message'] ?? null;
        $this->code = isset($response['code']) ? (int) $response['code'] : null;
        $this->data = $response['data'] ?? null;
    }

    /**
     * Check if the response indicates success
     */
    public function isSuccess(): bool
    {
        return $this->status === 'ok' || $this->status === 'success';
    }

    /**
     * Check if the response indicates an error
     */
    public function isError(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * Get the error code if present
     */
    public function getErrorCode(): ?int
    {
        return $this->isError() ? $this->code : null;
    }

    /**
     * Get a specific data field
     */
    public function get(string $key, mixed $default = null): mixed
    {
        if (is_array($this->data)) {
            return $this->data[$key] ?? $default;
        }
        return $default;
    }

    /**
     * Convert response to array
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
