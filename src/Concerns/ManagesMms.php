<?php

namespace Swiftsms\Concerns;

trait ManagesMms
{
    /**
     * Send MMS
     *
     * @param string|array $phones
     * @param string $message
     * @param string $mediaUrl
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function send_mms($phones, $message, $mediaUrl, array $options = []): mixed
    {
        if (empty($phones)) {
            throw new \InvalidArgumentException('Phones cannot be empty');
        }
        if (empty($mediaUrl)) {
            throw new \InvalidArgumentException('Media URL cannot be empty for MMS');
        }

        $extraData = array_merge([
            'type' => 'mms',
            'media_url' => $mediaUrl
        ], $options);

        return $this->sendServerResponse(self::BASE_URL . '/sms/send', self::phone($phones), $message, 'post', $extraData);
    }
}
