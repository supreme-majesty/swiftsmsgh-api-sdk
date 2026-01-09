<?php

namespace Swiftsms\Concerns;

trait ManagesVoice
{
    /**
     * Send Voice SMS
     *
     * @param string|array $phones
     * @param string $message
     * @param string $gender (male/female)
     * @param string $language (e.g., en-gb)
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function send_voice($phones, $message, $gender = 'female', $language = 'en-gb', array $options = []): mixed
    {
        if (empty($phones) || empty($message)) {
            throw new \InvalidArgumentException('Phones and message cannot be empty');
        }

        $extraData = array_merge([
            'type' => 'voice',
            'gender' => $gender,
            'language' => $language
        ], $options);

        return $this->sendServerResponse(self::BASE_URL . '/sms/send', self::phone($phones), $message, 'post', $extraData);
    }
}
