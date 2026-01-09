# Swiftsms-GH PHP SDK

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.0-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Packagist](https://img.shields.io/packagist/v/swiftsmsgh/swiftsmsgh-api-sdk.svg)](https://packagist.org/packages/swiftsmsgh/swiftsmsgh-api-sdk)

The Swiftsms-GH PHP SDK provides a suitable approach to the Swiftsms-GH API from applications written in PHP. It includes pre-defined set of classes and functions for API resource that initialize themselves from API responses.

The library provides other features. For Example:

1. Easy configuration path for fast setup and use
2. Helpers for pagination.

You can sign up for an Swiftsms-GH account at [swiftsmsgh.com](https://swiftsmsgh.com)

## Table of Contents

-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
-   [Documentation](#documentation)
-   [Usage](#usage)
-   [Exception Handling](#exception-handling)
-   [HTTP Endpoints](#http-endpoints)
-   [Send Messages](#send-messages)
    -   [Send SMS](#1-send-sms)
    -   [Schedule Message & Custom Sender ID](#2-schedule-message--custom-sender-id)
    -   [Send Voice Call](#3-send-voice-call)
    -   [Send MMS](#4-send-mms)
    -   [Send OTP](#5-send-otp)
    -   [Send WhatsApp](#6-send-whatsapp)
    -   [Send Viber](#7-send-viber)
-   [Contacts Management](#contacts-management)
    -   [Contact Groups](#contact-groups)
    -   [Individual Contacts](#individual-contacts)
-   [Check SMS Credit Balance](#check-sms-credit-balance)
-   [View Profile](#view-profile)
-   [Status Codes](#status-codes)
-   [Response Examples](#response-examples)
-   [Contributing](#contributing)
-   [Changelog](#changelog)
-   [License](#license)

## Prerequisites

PHP ^8.0 and later

## Installation

Via [Composer](http://getcomposer.org/)

```bash
$ composer require swiftsmsgh/swiftsmsgh-api-sdk
```

Via Git Bash

```bash
git clone git@github.com:supreme-majesty/swiftsmsgh-api-sdk.git
```

## Documentation

Please see [https://swiftsmsgh.com/developer](https://swiftsmsgh.com/developer) for up-to-date documentation

## Usage

### Step 1:

If you install the Swiftsms-GH PHP SDK via Git Clone then load the Swiftsms-GH PHP API class file and use namespace.

```php
require_once '/path/to/src/Swiftsmsgh.php';
use Swiftsms\Swiftsmsgh;
```

If you install Swiftsms-GH PHP SDK via [Composer](http://getcomposer.org/) require the autoload.php file in the index.php of your project or whatever file you need to use Swiftsms-GH PHP API classes.

```php
require __DIR__ . '/vendor/autoload.php';
use Swiftsms\Swiftsmsgh;
```

The Swiftsms-GH PHP SDK endpoints are RESTful, and consume and return JSON. All Http endpoints requires an API Key in the request header.

For more information on how to get an API Key visit [here](https://swiftsmsgh.com/developers) to copy or generate new key for authorization.

## Exception Handling

The SDK throws `Swiftsms\SwiftsmsException` when an API or network error occurs.

```php
try {
    $response = $client->send_sms($recipients, $message);
} catch (Swiftsms\SwiftsmsException $e) {
    echo "Error: " . $e->getMessage();
}
```

## HTTP Endpoints

-   https://swiftsmsgh.com/api/v3/sms/send
-   https://swiftsmsgh.com/api/v3/sms/{uid}
-   https://swiftsmsgh.com/api/v3/sms
-   https://swiftsmsgh.com/api/v3/me
-   https://swiftsmsgh.com/api/v3/balance
-   https://swiftsmsgh.com/api/v3/contacts
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}/show/
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}/store
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}/search/{uid}
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}/update/{uid}
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}/delete/{uid}
-   https://swiftsmsgh.com/api/v3/contacts/{group_id}/all

### Step 2:

Instantiate the SwiftsmsghSMSSDKAPI

```php
$api_token = "Enter Your API Token here";

$sender_id = "Enter your approved Sender ID here";

$client = new Swiftsms\Swiftsmsgh($api_token, $sender_id);
```

## Send Messages

### 1. Send SMS

```php
$recipients = "233538000000,233540000000";
$message = "This is a test message";

$response = $client->send_sms($recipients, $message);
```

### 2. Schedule Message & Custom Sender ID

You can pass an optional `$options` array to any sending method.

```php
$options = [
    'schedule_time' => '2025-12-25 08:00', // Format: Y-m-d H:i
    'sender_id'     => 'MyAlert'           // Override default Sender ID
];

$client->send_sms($recipients, $message, $options);
```

### 3. Send Voice Call

```php
// gender: 'male' or 'female'
// language: 'en-gb', 'en-us', etc.
$client->send_voice($recipients, "Wake up!", "female", "en-gb");
```

### 4. Send MMS

```php
$mediaUrl = "https://example.com/image.jpg";
$client->send_mms($recipients, "Here is the photo", $mediaUrl);
```

### 5. Send OTP

```php
$client->send_otp($recipients, "Your verification code is 1234");
```

### 6. Send WhatsApp

```php
$client->send_whatsapp($recipients, "Hello from WhatsApp API");
```

### 7. Send Viber

```php
$client->send_viber($recipients, "Hello from Viber API");
```

## Contacts Management

### Contact Groups

```php
// Get all contact groups
$groups = $client->all_contact_groups();

// View a specific contact group
$group = $client->view_contact_group($group_id);

// Create a new contact group
$client->create_contact_group($phones, $groupName);

// Update a contact group
$client->update_contact_group($phones, $groupName);

// Delete a contact group
$client->delete_contact_group($group_id);
```

### Individual Contacts

```php
// Get all contacts in a group
$contacts = $client->all_contacts_in_group($group_id);

// View a specific contact
$contact = $client->view_contact($group_id, $uid);

// Create a new contact
$client->create_contact($phones, $message);

// Update a contact
$client->update_contact($phones, $message);

// Delete a contact
$client->delete_contact($group_id, $uid);
```

## Check SMS Credit Balance

```php
$get_credit_balance = $client->check_balance();
```

## View Profile

```php
$get_profile = $client->profile();
```

## Status Codes

| Status | Message                                  |
| ------ | ---------------------------------------- |
| `ok`   | Successfully Send                        |
| `100`  | Bad gateway requested                    |
| `101`  | Wrong action                             |
| `102`  | Authentication failed                    |
| `103`  | Invalid phone number                     |
| `104`  | Phone coverage not active                |
| `105`  | Insufficient balance                     |
| `106`  | Invalid Sender ID                        |
| `107`  | Invalid SMS Type                         |
| `108`  | SMS Gateway not active                   |
| `109`  | Invalid Schedule Time                    |
| `110`  | Media url required                       |
| `111`  | SMS contain spam word. Wait for approval |

## Response Examples

### Successful SMS Send

```json
{
    "status": "ok",
    "message": "Successfully Send",
    "data": {
        "uid": "abc123xyz",
        "to": "233538000000",
        "message": "This is a test message",
        "status": "delivered"
    }
}
```

### Balance Check

```json
{
    "status": "ok",
    "data": {
        "remaining_balance": 150.5,
        "currency": "GHS"
    }
}
```

### Error Response

```json
{
    "status": "error",
    "code": 102,
    "message": "Authentication failed"
}
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on how to contribute to this project.

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for a list of changes.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
