<?php

namespace Swiftsms\Concerns;

trait ManagesWhatsApp
{
    /**
     * Send WhatsApp Message
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function send_whatsapp($phones, $message, array $options = []): mixed
    {
        if (empty($phones) || empty($message)) {
            throw new \InvalidArgumentException('Phones and message cannot be empty');
        }

        $extraData = array_merge([
            'type' => 'whatsapp'
        ], $options);

        return $this->sendServerResponse(self::BASE_URL . '/sms/send', self::phone($phones), $message, 'post', $extraData);
    }

    /**
     * Send Viber Message
     *
     * @param string|array $phones
     * @param string $message
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function send_viber($phones, $message, array $options = []): mixed
    {
        if (empty($phones) || empty($message)) {
            throw new \InvalidArgumentException('Phones and message cannot be empty');
        }

        $extraData = array_merge([
            'type' => 'viber'
        ], $options);

        return $this->sendServerResponse(self::BASE_URL . '/sms/send', self::phone($phones), $message, 'post', $extraData);
    }
}
