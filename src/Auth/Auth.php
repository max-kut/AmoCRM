<?php

namespace AmoPRO\AmoCRM\Auth;

use AmoCRM\OAuth2\Client\Provider\AmoCRM;
use AmoPRO\AmoCRM\Exceptions\WrongDomainException;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\RequestOptions;
use League\OAuth2\Client\Grant\AuthorizationCode;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Token\AccessToken;

class Auth
{
    /** @var string $domain */
    private $domain;
    /** @var \League\OAuth2\Client\Token\AccessToken $accessToken */
    private $accessToken;
    /** @var \AmoCRM\OAuth2\Client\Provider\AmoCRM $provider */
    private $provider;
    /** @var string $authorizationCode */
    private $authorizationCode;
    /** @var callable[] $listeners */
    private $listeners = [];

    /**
     * Auth constructor.
     *
     * @param string $domain
     * @param \AmoPRO\AmoCRM\Auth\Client $client
     */
    public function __construct(string $domain, Client $client)
    {
        $this->domain = $this->prepareDomain($domain);

        $providerData = $client->toArray();
        $providerData['baseDomain'] = substr($this->domain, 8);
        $providerData['state'] = uniqid('amo-', true);
        $this->provider = new AmoCRM($providerData, [
            'httpClient' => new HttpClient([
                RequestOptions::VERIFY => false,
                RequestOptions::TIMEOUT => 100,
                RequestOptions::CONNECT_TIMEOUT => 100
            ])
        ]);
    }

    /**
     * @param string $domain
     * @return string
     */
    private function prepareDomain(string $domain): string
    {
        $pattern = '/^(https?:\/\/)?(?P<account>[a-z0-9]+)(?P<z1>\.z1)?(?P<amo>\.amocrm\.ru)?/i';
        if (preg_match($pattern, $domain, $matches)) {
            return implode('', array_filter([
                'https://',
                $matches['account'],
                $matches['z1'] ?? null,
                $matches['amo'] ?? '.amocrm.ru'
            ]));
        }

        throw new WrongDomainException("Domain '{$domain}' is wrong");
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return AccessToken|null
     */
    public function getAccessToken(): ?AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @param mixed $accessToken
     * @return static
     */
    public function setAccessToken(AccessToken $accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @param string|null $authorizationCode
     * @return static
     */
    public function setAuthorizationCode(?string $authorizationCode)
    {
        $this->authorizationCode = $authorizationCode;

        return $this;
    }

    /**
     * @return bool
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function requestNewToken(): bool
    {
        if ($this->accessToken && ($refreshToken = $this->accessToken->getRefreshToken())) {
            $this->setAccessToken($this->provider->getAccessToken(new RefreshToken(), [
                'refresh_token' => $refreshToken
            ]));
            $this->triggerUpdated();

            return true;
        }

        if ($this->authorizationCode) {
            $this->setAccessToken($this->provider->getAccessToken(new AuthorizationCode(), [
                'code' => $this->authorizationCode
            ]));
            $this->triggerUpdated();

            return true;
        }

        return false;
    }

    /**
     * @param callable $callback
     * @return static
     */
    public function tokenUpdated(callable $callback)
    {
        $this->listeners[] = $callback;

        return $this;
    }

    /**
     * trigger
     */
    private function triggerUpdated()
    {
        foreach ($this->listeners as $callback) {
            call_user_func($callback, $this->accessToken);
        }
    }
}
