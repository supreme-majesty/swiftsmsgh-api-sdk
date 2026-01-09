<?php

namespace Swiftsms\Tests;

use PHPUnit\Framework\TestCase;
use Swiftsms\Swiftsmsgh;

class SwiftsmsghTest extends TestCase
{
    private Swiftsmsgh $client;

    protected function setUp(): void
    {
        $this->client = new Swiftsmsgh('test_token', 'test_sender');
    }

    public function testInitialization(): void
    {
        $this->assertInstanceOf(Swiftsmsgh::class, $this->client);
    }

    public function testBaseUrlConstant(): void
    {
        $this->assertEquals('https://swiftsmsgh.com/api/v3', Swiftsmsgh::BASE_URL);
    }

    public function testGetAndSetSenderId(): void
    {
        $this->assertEquals('test_sender', $this->client->getSenderId());
        $this->client->setSenderId('new_sender');
        $this->assertEquals('new_sender', $this->client->getSenderId());
    }

    public function testSendSmsThrowsExceptionOnEmptyArgs(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_sms('', '');
    }

    public function testSendSmsThrowsExceptionOnEmptyPhones(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_sms('', 'Hello');
    }

    public function testSendSmsThrowsExceptionOnEmptyMessage(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_sms('123456', '');
    }

    public function testViewSmsThrowsExceptionOnEmptyUid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->view_sms('');
    }

    public function testContactGroupThrowsExceptionOnEmptyArgs(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->create_contact_group([], '');
    }

    public function testViewContactGroupThrowsExceptionOnEmptyId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->view_contact_group('');
    }

    /*
     * Feature Tests: Voice, MMS, OTP, Apps
     */

    public function testVoiceThrowsExceptionOnEmptyArgs(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_voice('', 'Message');
    }

    public function testMmsThrowsExceptionOnEmptyMediaUrl(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_mms(['123'], 'Message', '');
    }

    public function testOtpThrowsExceptionOnEmptyArgs(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_otp([], '');
    }

    public function testWhatsappThrowsExceptionOnEmptyArgs(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_whatsapp([], '');
    }

    public function testViberThrowsExceptionOnEmptyArgs(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->client->send_viber([], '');
    }

    public function testConstructorThrowsWithoutApiToken(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('API token is required');
        new Swiftsmsgh(null, null);
    }
}
