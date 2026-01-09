<?php

namespace Swiftsms\Concerns;

trait ManagesContacts
{
    /**
     * Create a new Contact Group
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function create_contact_group($phones, $message): mixed
    {
        if (empty($phones) || empty($message)) {
            throw new \InvalidArgumentException('Phones and message cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . '/sms/send', $phones, $message, 'post');
    }

    /**
     * View Contact Group
     *
     * @param string $group_id
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function view_contact_group($group_id): mixed
    {
        if (empty($group_id)) {
            throw new \InvalidArgumentException('Group ID cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . '/contacts/' . $group_id, '', '', 'post');
    }

    /**
     * Update Contact Group
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     */
    public function update_contact_group($phones, $message): mixed
    {
        return $this->sendServerResponse(self::BASE_URL . '/sms/send', $phones, $message, 'patch');
    }

    /**
     * Delete Contact Group
     *
     * @param string $group_id
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function delete_contact_group($group_id): mixed
    {
        if (empty($group_id)) {
            throw new \InvalidArgumentException('Group ID cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . '/contacts/' . $group_id, '', '', 'delete');
    }

    /**
     * View all Contact Groups
     *
     * @return mixed
     */
    public function all_contact_groups(): mixed
    {
        return $this->sendServerResponse(self::BASE_URL . '/contacts', '', '');
    }

    /**
     * Creates a new contact object
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function create_contact($phones, $message): mixed
    {
        if (empty($phones) || empty($message)) {
            throw new \InvalidArgumentException('Phones and message cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . '/sms/send', $phones, $message, 'post');
    }

    /**
     * Retrieves the information of an existing contact
     *
     * @param string $group_id
     * @param string $uid
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function view_contact($group_id, $uid): mixed
    {
        if (empty($group_id) || empty($uid)) {
            throw new \InvalidArgumentException('Group ID and UID cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . "/contacts/$group_id/search/$uid", '', '', 'post');
    }

    /**
     * Update an existing contact.
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     */
    public function update_contact($phones, $message): mixed
    {
        return $this->sendServerResponse(self::BASE_URL . '/sms/send', $phones, $message, 'patch');
    }

    /**
     * Delete an existing contact
     *
     * @param string $group_id
     * @param string $uid
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function delete_contact($group_id, $uid): mixed
    {
        if (empty($group_id) || empty($uid)) {
            throw new \InvalidArgumentException('Group ID and UID cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . "/contacts/$group_id/delete/$uid", '', '', 'delete');
    }

    /**
     * View all contacts in group
     *
     * @param string $group_id
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function all_contacts_in_group($group_id): mixed
    {
        if (empty($group_id)) {
            throw new \InvalidArgumentException('Group ID cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . "/contacts/$group_id/all", '', '', 'post');
    }
}
