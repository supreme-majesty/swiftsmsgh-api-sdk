<?php

namespace Swiftsms\Tests;

use PHPUnit\Framework\TestCase;
use Swiftsms\Response;

class ResponseTest extends TestCase
{
    public function testSuccessResponse(): void
    {
        $response = new Response([
            'status' => 'ok',
            'message' => 'Successfully Send',
            'data' => ['uid' => 'abc123']
        ]);

        $this->assertTrue($response->isSuccess());
        $this->assertFalse($response->isError());
        $this->assertEquals('ok', $response->status);
        $this->assertEquals('Successfully Send', $response->message);
        $this->assertEquals('abc123', $response->get('uid'));
    }

    public function testErrorResponse(): void
    {
        $response = new Response([
            'status' => 'error',
            'code' => 102,
            'message' => 'Authentication failed'
        ]);

        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->isError());
        $this->assertEquals(102, $response->getErrorCode());
        $this->assertEquals('Authentication failed', $response->message);
    }

    public function testGetWithDefault(): void
    {
        $response = new Response([
            'status' => 'ok',
            'data' => ['foo' => 'bar']
        ]);

        $this->assertEquals('bar', $response->get('foo'));
        $this->assertEquals('default', $response->get('missing', 'default'));
        $this->assertNull($response->get('missing'));
    }

    public function testToArray(): void
    {
        $raw = [
            'status' => 'ok',
            'message' => 'Test',
            'data' => ['key' => 'value']
        ];
        $response = new Response($raw);

        $this->assertEquals($raw, $response->toArray());
    }
}
