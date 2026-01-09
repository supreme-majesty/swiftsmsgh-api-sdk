<?php

namespace Swiftsms;

/**
 * Swiftsms-GH API Client
 *
 * @method Response send_sms(string|array $phones, string $message, array $options = [])
 * @method Response send_voice(string|array $phones, string $message, string $gender = 'female', string $language = 'en-gb', array $options = [])
 * @method Response send_mms(string|array $phones, string $message, string $mediaUrl, array $options = [])
 * @method Response send_otp(string|array $phones, string $message, array $options = [])
 * @method Response send_whatsapp(string|array $phones, string $message, array $options = [])
 * @method Response send_viber(string|array $phones, string $message, array $options = [])
 * @method Response check_balance()
 * @method Response profile()
 * @method Response view_sms(string $uid)
 * @method Response all_contact_groups()
 * @method Response view_contact_group(string $groupId)
 * @method Response create_contact_group(string|array $phones, string $message)
 * @method Response update_contact_group(string|array $phones, string $message)
 * @method Response delete_contact_group(string $groupId)
 * @method Response all_contacts_in_group(string $groupId)
 * @method Response view_contact(string $groupId, string $uid)
 * @method Response create_contact(string|array $phones, string $message)
 * @method Response update_contact(string|array $phones, string $message)
 * @method Response delete_contact(string $groupId, string $uid)
 */
class Swiftsmsgh
{
    use Concerns\ManagesSms;
    use Concerns\ManagesContacts;
    use Concerns\ManagesVoice;
    use Concerns\ManagesMms;
    use Concerns\ManagesOtp;
    use Concerns\ManagesWhatsApp;

    private HttpClient $client;
    public const BASE_URL = 'https://swiftsmsgh.com/api/v3';

    /**
     * Create a new Swiftsmsgh client
     *
     * @param string|null $apiToken API token (or use SWIFTSMS_API_TOKEN env var)
     * @param string|null $senderId Sender ID (or use SWIFTSMS_SENDER_ID env var)
     * @param HttpClient|null $httpClient Optional injected HTTP client for testing
     */
    public function __construct(
        private ?string $apiToken = null,
        private ?string $senderId = null,
        ?HttpClient $httpClient = null
    ) {
        // Support environment-based configuration
        $this->apiToken = $apiToken ?? ($_ENV['SWIFTSMS_API_TOKEN'] ?? getenv('SWIFTSMS_API_TOKEN') ?: null);
        $this->senderId = $senderId ?? ($_ENV['SWIFTSMS_SENDER_ID'] ?? getenv('SWIFTSMS_SENDER_ID') ?: null);

        if (empty($this->apiToken)) {
            throw new \InvalidArgumentException('API token is required. Pass it to constructor or set SWIFTSMS_API_TOKEN environment variable.');
        }

        $this->client = $httpClient ?? new HttpClient($this->apiToken);
    }

    /**
     * Get the current sender ID
     */
    public function getSenderId(): ?string
    {
        return $this->senderId;
    }

    /**
     * Set the sender ID
     */
    public function setSenderId(string $senderId): self
    {
        $this->senderId = $senderId;
        return $this;
    }

    /**
     * Send Request to server and get sms status
     *
     * @param string $endpoint API endpoint URL
     * @param string|array $recipient Phone number(s)
     * @param string $message Message content
     * @param string|null $requestMethod HTTP method
     * @param array $extraData Additional payload data
     * @return Response Response object
     * @throws SwiftsmsException
     */
    protected function sendServerResponse(
        string $endpoint,
        string|array $recipient,
        string $message,
        ?string $requestMethod = null,
        array $extraData = []
    ): Response {
        $payload = [
            'recipient' => $recipient,
            'sender_id' => $this->senderId,
            'message' => $message,
        ];

        if (!empty($extraData)) {
            $payload = array_merge($payload, $extraData);
        }

        $method = $requestMethod ? strtoupper($requestMethod) : 'POST';

        // Map legacy method names if necessary or rely on HttpClient to handle standard methods
        if (empty($requestMethod)) {
            // Default behavior if requestMethod is null was specific in old code...
            // In old code: if null, it didn't set POST/PUT/etc, so it defaulted to GET unless payload was set?
            // Actually existing code logic:
            // if post -> set post
            // if put -> set put
            // etc..
            // The method sendServerResponse is usually called with 'post', 'patch', 'delete'.
            // For 'get', it is called with empty string mostly?
            // Let's check traits.
            // ManagesSms::check_balance calls sendServerResponse(..., '', '') (empty recipient, empty message, default method null)

            // If recipient and message are empty, maybe it's a GET?
            // Old code:
            // if $requestMethod is null, no curl option set for method.
            // But curl_setopt($this->curlHandle, CURLOPT_URL, $endpoint); is set.
            // If no CURLOPT_POST or CUSTOMREQUEST is set, it defaults to GET.

            $method = 'GET';
        }

        // Logic correction: explicit method passed wins
        if ($requestMethod) {
            $method = strtoupper($requestMethod);
        }

        $responseArray = $this->client->request($method, $endpoint, $payload);

        return new Response($responseArray);
    }
}
