<?php

namespace AmoPRO\AmoCRM\Methods;

use AmoPRO\AmoCRM\Client;
use AmoPRO\AmoCRM\Exceptions\WrongJsonResponseError;
use GuzzleHttp\Psr7\Request;

abstract class AbstractMethod
{
    /** @var \AmoPRO\AmoCRM\Client $client */
    protected $client;

    /**
     * AbstractMethod constructor.
     *
     * @param \AmoPRO\AmoCRM\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param \GuzzleHttp\Psr7\Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function prepareResponse(Request $request): array
    {
        $data = json_decode($this->client->send($request)->getBody()->getContents(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new WrongJsonResponseError(
                'json_decode error: ' . json_last_error_msg()
            );
        }

        return $data;
    }
}