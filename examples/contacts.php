<?php

/**
 * Swiftsms-GH SDK - Contacts Management Example
 *
 * This example demonstrates contact group and individual contact management.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Swiftsms\Swiftsmsgh;
use Swiftsms\SwiftsmsException;

$client = new Swiftsmsgh(
    apiToken: 'your-api-token-here',
    senderId: 'YourSenderID'
);

try {
    // =====================
    // Contact Groups
    // =====================

    // List all contact groups
    echo "=== All Contact Groups ===\n";
    $groups = $client->all_contact_groups();
    print_r($groups);

    // View a specific contact group
    $groupId = 'your-group-id';
    $group = $client->view_contact_group($groupId);
    print_r($group);

    // Delete a contact group
    // $client->delete_contact_group($groupId);

    // =====================
    // Individual Contacts
    // =====================

    // List all contacts in a group
    echo "\n=== Contacts in Group ===\n";
    $contacts = $client->all_contacts_in_group($groupId);
    print_r($contacts);

    // View a specific contact
    $contactUid = 'contact-uid';
    $contact = $client->view_contact($groupId, $contactUid);
    print_r($contact);

    // Delete a contact
    // $client->delete_contact($groupId, $contactUid);

} catch (SwiftsmsException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
} catch (\InvalidArgumentException $e) {
    echo "Validation Error: " . $e->getMessage() . "\n";
}
