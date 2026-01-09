<?php

/**
 * Swiftsms-GH SDK - Send SMS Example
 *
 * This example demonstrates how to send SMS messages using the SDK.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Swiftsms\Swiftsmsgh;
use Swiftsms\SwiftsmsException;

// Option 1: Pass credentials directly
$client = new Swiftsmsgh(
    apiToken: 'your-api-token-here',
    senderId: 'YourSenderID'
);

// Option 2: Use environment variables
// Set SWIFTSMS_API_TOKEN and SWIFTSMS_SENDER_ID in your environment
// $client = new Swiftsmsgh();

try {
    // Send a single SMS
    $response = $client->send_sms(
        phones: '233538000000',
        message: 'Hello from Swiftsms-GH SDK!'
    );

    print_r($response);

    // Send to multiple recipients
    $response = $client->send_sms(
        phones: '233538000000,233540000000',
        message: 'Bulk message example'
    );

    print_r($response);

    // Schedule a message
    $response = $client->send_sms(
        phones: '233538000000',
        message: 'This is a scheduled message',
        options: [
            'schedule_time' => '2026-01-15 09:00',
            'sender_id' => 'CustomID'  // Override default sender ID
        ]
    );

    print_r($response);

    // Check balance
    $balance = $client->check_balance();
    echo "Remaining balance: " . ($balance['data']['remaining_balance'] ?? 'N/A') . "\n";

    // View profile
    $profile = $client->profile();
    print_r($profile);

} catch (SwiftsmsException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
} catch (\InvalidArgumentException $e) {
    echo "Validation Error: " . $e->getMessage() . "\n";
}
