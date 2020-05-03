<?php

namespace AmoPRO\AmoCRM\Auth;

use AmoPRO\AmoCRM\Contracts\Arrayable;

class Client implements Arrayable
{
    private $attributes = [];

    /**
     * Client constructor.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUri
     */
    public function __construct(string $clientId, string $clientSecret, string $redirectUri)
    {
        $this->attributes = compact('clientId', 'clientSecret', 'redirectUri');
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->attributes;
    }
}