<?php

namespace Swiftsms\Tests;

/**
 * Mock HTTP Client for Unit Tests
 *
 * Allows testing without making real API calls
 */
class MockHttpClient
{
    private array $responses = [];
    private array $requests = [];

    /**
     * Queue a response to be returned
     */
    public function queueResponse(array $response): self
    {
        $this->responses[] = $response;
        return $this;
    }

    /**
     * Get all recorded requests
     */
    public function getRequests(): array
    {
        return $this->requests;
    }

    /**
     * Get the last recorded request
     */
    public function getLastRequest(): ?array
    {
        return end($this->requests) ?: null;
    }

    /**
     * Clear all queued responses and recorded requests
     */
    public function reset(): self
    {
        $this->responses = [];
        $this->requests = [];
        return $this;
    }

    /**
     * Simulate an API request
     */
    public function request(string $method, string $url, array $payload = []): array
    {
        $this->requests[] = [
            'method' => $method,
            'url' => $url,
            'payload' => $payload,
        ];

        if (empty($this->responses)) {
            return [
                'status' => 'ok',
                'message' => 'Mock response',
                'data' => []
            ];
        }

        return array_shift($this->responses);
    }

    /**
     * Create a successful SMS response
     */
    public static function successResponse(string $message = 'Successfully Send'): array
    {
        return [
            'status' => 'ok',
            'message' => $message,
            'data' => [
                'uid' => 'mock-uid-' . uniqid(),
                'status' => 'delivered'
            ]
        ];
    }

    /**
     * Create an error response
     */
    public static function errorResponse(int $code, string $message): array
    {
        return [
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ];
    }

    /**
     * Create a balance response
     */
    public static function balanceResponse(float $balance): array
    {
        return [
            'status' => 'ok',
            'data' => [
                'remaining_balance' => $balance,
                'currency' => 'GHS'
            ]
        ];
    }
}
