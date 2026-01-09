<?php

namespace Swiftsms\Concerns;

trait ManagesSms
{
    /**
     * Send single / group SMS
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function send_sms($phones, $message, array $options = []): mixed
    {
        if (empty($phones)) {
            throw new \InvalidArgumentException('Recipient phones cannot be empty');
        }
        if (empty($message)) {
            throw new \InvalidArgumentException('Message cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . '/sms/send', self::phone($phones), $message, 'post', $options);
    }

    /**
     * View an SMS
     *
     * @param string $uid
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function view_sms($uid): mixed
    {
        if (empty($uid)) {
            throw new \InvalidArgumentException('UID cannot be empty');
        }
        return $this->sendServerResponse(self::BASE_URL . '/sms/' . $uid, '', '');
    }

    /**
     * View sms credit balance
     *
     * @return mixed
     */
    public function check_balance(): mixed
    {
        return $this->sendServerResponse(self::BASE_URL . '/balance', '', '');
    }

    /**
     * View profile
     *
     * @return mixed
     */
    public function profile(): mixed
    {
        return $this->sendServerResponse(self::BASE_URL . '/me', '', '');
    }

    /**
     * Format the phone number
     *
     * @param string|array $phone
     * @param string $code
     * @return array|string|null
     */
    protected static function phone(string|array $phone, string $code = '233'): array|string|null
    {
        return preg_replace('/^0/', $code, $phone);
    }
}
