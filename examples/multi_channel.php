<?php

/**
 * Swiftsms-GH SDK - Multi-Channel Messaging Example
 *
 * This example demonstrates Voice, MMS, OTP, WhatsApp, and Viber messaging.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Swiftsms\Swiftsmsgh;
use Swiftsms\SwiftsmsException;

$client = new Swiftsmsgh(
    apiToken: 'your-api-token-here',
    senderId: 'YourSenderID'
);

$phone = '233538000000';

try {
    // =====================
    // Voice Call
    // =====================
    echo "=== Sending Voice Call ===\n";
    $response = $client->send_voice(
        phones: $phone,
        message: 'This is an automated voice message from Swiftsms-GH.',
        gender: 'female',  // 'male' or 'female'
        language: 'en-gb'  // 'en-us', 'en-gb', etc.
    );
    print_r($response);

    // =====================
    // MMS (Multimedia Message)
    // =====================
    echo "\n=== Sending MMS ===\n";
    $response = $client->send_mms(
        phones: $phone,
        message: 'Check out this image!',
        mediaUrl: 'https://example.com/image.jpg'
    );
    print_r($response);

    // =====================
    // OTP (One-Time Password)
    // =====================
    echo "\n=== Sending OTP ===\n";
    $otp = random_int(100000, 999999);
    $response = $client->send_otp(
        phones: $phone,
        message: "Your verification code is: {$otp}. Valid for 5 minutes."
    );
    print_r($response);

    // =====================
    // WhatsApp Message
    // =====================
    echo "\n=== Sending WhatsApp ===\n";
    $response = $client->send_whatsapp(
        phones: $phone,
        message: 'Hello from WhatsApp API!'
    );
    print_r($response);

    // =====================
    // Viber Message
    // =====================
    echo "\n=== Sending Viber ===\n";
    $response = $client->send_viber(
        phones: $phone,
        message: 'Hello from Viber API!'
    );
    print_r($response);

} catch (SwiftsmsException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
} catch (\InvalidArgumentException $e) {
    echo "Validation Error: " . $e->getMessage() . "\n";
}
