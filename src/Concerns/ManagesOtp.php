<?php

namespace Swiftsms\Concerns;

trait ManagesOtp
{
    /**
     * Send OTP
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function send_otp($phones, $message, array $options = []): mixed
    {
        if (empty($phones) || empty($message)) {
            throw new \InvalidArgumentException('Phones and message cannot be empty');
        }

        $extraData = array_merge([
            'type' => 'otp'
        ], $options);

        return $this->sendServerResponse(self::BASE_URL . '/sms/send', self::phone($phones), $message, 'post', $extraData);
    }
}
