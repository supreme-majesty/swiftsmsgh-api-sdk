<?php

namespace Swiftsms;

/**
 * HTTP Client with retry logic
 *
 * Handles HTTP requests with automatic retry on transient failures
 */
class HttpClient
{
    private \CurlHandle|null $curlHandle = null;
    private int $maxRetries;
    private int $baseDelayMs;

    public function __construct(
        private string $apiToken,
        int $maxRetries = 3,
        int $baseDelayMs = 100
    ) {
        $this->maxRetries = $maxRetries;
        $this->baseDelayMs = $baseDelayMs;
        $this->curlHandle = curl_init();
    }

    public function __destruct()
    {
        if ($this->curlHandle) {
            curl_close($this->curlHandle);
        }
    }

    /**
     * Send HTTP request with retry logic
     *
     * @param string $method HTTP method (GET, POST, PUT, PATCH, DELETE)
     * @param string $url Full URL to request
     * @param array $payload Request payload
     * @return array Response data
     * @throws SwiftsmsException
     */
    public function request(string $method, string $url, array $payload = []): array
    {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $this->maxRetries) {
            try {
                return $this->executeRequest($method, $url, $payload);
            } catch (SwiftsmsException $e) {
                $lastException = $e;

                // Don't retry on client errors (4xx)
                if ($this->isClientError($e->getMessage())) {
                    throw $e;
                }

                $attempt++;
                if ($attempt < $this->maxRetries) {
                    $this->sleep($attempt);
                }
            }
        }

        throw $lastException ?? new SwiftsmsException('Request failed after ' . $this->maxRetries . ' attempts');
    }

    /**
     * Execute a single HTTP request
     */
    private function executeRequest(string $method, string $url, array $payload): array
    {
        curl_setopt($this->curlHandle, CURLOPT_URL, $url);
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiToken
        ]);
        curl_setopt($this->curlHandle, CURLOPT_TIMEOUT, 20);
        curl_setopt($this->curlHandle, CURLOPT_CONNECTTIMEOUT, 20);

        $method = strtoupper($method);

        if ($method === 'POST') {
            curl_setopt($this->curlHandle, CURLOPT_POST, true);
            curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, json_encode($payload));
        } elseif (in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
            curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, $method);
            if (!empty($payload)) {
                curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, json_encode($payload));
            }
        } else {
            curl_setopt($this->curlHandle, CURLOPT_HTTPGET, true);
        }

        $response = curl_exec($this->curlHandle);

        if ($error = curl_error($this->curlHandle)) {
            throw new SwiftsmsException($error);
        }

        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new SwiftsmsException('Invalid JSON response: ' . json_last_error_msg());
        }

        return $decoded;
    }

    /**
     * Check if error is a client error (shouldn't retry)
     */
    private function isClientError(string $message): bool
    {
        // Authentication, validation errors shouldn't be retried
        $clientErrors = ['Authentication failed', 'Invalid', 'required'];
        foreach ($clientErrors as $error) {
            if (str_contains($message, $error)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Sleep with exponential backoff
     */
    private function sleep(int $attempt): void
    {
        $delayMs = $this->baseDelayMs * (2 ** ($attempt - 1));
        usleep($delayMs * 1000);
    }
}
