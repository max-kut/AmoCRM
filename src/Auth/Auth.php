<?php

namespace AmoPRO\AmoCRM\Auth;

use AmoCRM\OAuth2\Client\Provider\AmoCRMException;
use AmoPRO\AmoCRM\Exceptions\Http\UnauthorizedException;
use AmoPRO\AmoCRM\Exceptions\WrongDomainException;
use League\OAuth2\Client\Grant\AuthorizationCode;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Log\LoggerInterface;

class Auth
{
    /** @var string $domain */
    private $domain;
    /** @var \League\OAuth2\Client\Token\AccessToken $accessToken */
    private $accessToken;
    /** @var string $authorizationCode */
    private $authorizationCode;
    /** @var callable[] $listeners */
    private $listeners = [];
    /** @var \AmoPRO\AmoCRM\Auth\ProviderFactory $providerFactory */
    private $providerFactory;

    /**
     * Auth constructor.
     *
     * @param string $domain
     * @param \AmoPRO\AmoCRM\Auth\Client $client
     */
    public function __construct(string $domain, Client $client)
    {
        $this->domain = $this->prepareDomain($domain);

        $this->providerFactory = new ProviderFactory(
            substr($this->domain, 8), // clean protocol "https://"
            $client
        );
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
     * @param \Psr\Log\LoggerInterface|null $logger
     * @return bool
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function requestNewToken(?LoggerInterface $logger = null): bool
    {
        $provider = $this->providerFactory->make($logger);
        if ($this->getAccessToken() && ($refreshToken = $this->getAccessToken()->getRefreshToken())) {
            $this->setAccessToken($provider->getAccessToken(new RefreshToken(), [
                'refresh_token' => $refreshToken
            ]));
            $this->triggerUpdated();

            return true;
        }

        if ($this->authorizationCode) {
            $this->setAccessToken($provider->getAccessToken(new AuthorizationCode(), [
                'code' => $this->authorizationCode
            ]));
            $this->triggerUpdated();

            return true;
        }

        return false;
    }

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     * @throws \AmoCRM\OAuth2\Client\Provider\AmoCRMException
     */
    public function getResourceOwner(?LoggerInterface $logger = null): ResourceOwnerInterface
    {
        return $this->retrieveResourceOwner($logger);
    }

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @param int $attempt
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     * @throws \AmoCRM\OAuth2\Client\Provider\AmoCRMException
     * @throws \AmoPRO\AmoCRM\Exceptions\Http\UnauthorizedException
     */
    private function retrieveResourceOwner(?LoggerInterface $logger, $attempt = 1): ResourceOwnerInterface
    {
        if ($this->getAccessToken() === null && !empty($this->authorizationCode)) {
            $this->requestNewToken($logger);
        }

        if ($this->getAccessToken()) {
            try {
                return $this->providerFactory->make($logger)->getResourceOwner($this->getAccessToken());
            } /** @noinspection PhpRedundantCatchClauseInspection */
            catch (AmoCRMException $e) {
                if ($attempt < 5) {
                    usleep(200000);

                    return $this->retrieveResourceOwner($logger, $attempt + 1);
                }
                throw $e;
            }
        }

        throw new UnauthorizedException("For retrieve resource owner needs AccessToken or AuthorizationCode");
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
