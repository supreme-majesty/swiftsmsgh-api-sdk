<?php

namespace Swiftsms\Tests;

use PHPUnit\Framework\TestCase;
use Swiftsms\Swiftsmsgh;

/**
 * Integration Tests
 *
 * These tests require a valid API token and make real API calls.
 * They are skipped by default unless SWIFTSMS_API_TOKEN is set.
 *
 * To run: SWIFTSMS_API_TOKEN=your-token SWIFTSMS_SENDER_ID=YourID composer test
 *
 * @group integration
 */
class IntegrationTest extends TestCase
{
    private ?Swiftsmsgh $client = null;

    protected function setUp(): void
    {
        $apiToken = $_ENV['SWIFTSMS_API_TOKEN'] ?? getenv('SWIFTSMS_API_TOKEN');
        $senderId = $_ENV['SWIFTSMS_SENDER_ID'] ?? getenv('SWIFTSMS_SENDER_ID');

        if (empty($apiToken)) {
            $this->markTestSkipped('Integration tests require SWIFTSMS_API_TOKEN environment variable');
        }

        $this->client = new Swiftsmsgh($apiToken, $senderId ?: 'TestSender');
    }

    public function testCheckBalance(): void
    {
        $response = $this->client->check_balance();

        $this->assertInstanceOf(\Swiftsms\Response::class, $response);
        $this->assertEquals('ok', $response->status);
    }

    public function testViewProfile(): void
    {
        $response = $this->client->profile();

        $this->assertInstanceOf(\Swiftsms\Response::class, $response);
        $this->assertEquals('ok', $response->status);
    }

    public function testListContactGroups(): void
    {
        $response = $this->client->all_contact_groups();

        $this->assertInstanceOf(\Swiftsms\Response::class, $response);
        $this->assertEquals('ok', $response->status);
    }

    /**
     * Test sending SMS (commented out to avoid sending real messages)
     *
     * Uncomment and set SWIFTSMS_TEST_PHONE to test
     */
    // public function testSendSms(): void
    // {
    //     $phone = getenv('SWIFTSMS_TEST_PHONE');
    //     if (empty($phone)) {
    //         $this->markTestSkipped('Set SWIFTSMS_TEST_PHONE to test sending');
    //     }
    //
    //     $response = $this->client->send_sms($phone, 'Integration test message');
    //
    //     $this->assertIsArray($response);
    //     $this->assertEquals('ok', $response['status'] ?? null);
    // }
}
