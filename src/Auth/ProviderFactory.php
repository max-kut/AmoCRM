<?php

namespace AmoPRO\AmoCRM\Auth;

use AmoCRM\OAuth2\Client\Provider\AmoCRM as AmoCrmProvider;
use AmoPRO\AmoCRM\Middleware\LoggingMiddleware;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use function GuzzleHttp\choose_handler;

class ProviderFactory
{
    /**
     * @var string
     */
    private $baseDomain;
    /**
     * @var \AmoPRO\AmoCRM\Auth\Client
     */
    private $client;

    /**
     * ProviderFactory constructor.
     *
     * @param string $baseDomain
     * @param \AmoPRO\AmoCRM\Auth\Client $client
     */
    public function __construct(string $baseDomain, Client $client)
    {
        $this->baseDomain = $baseDomain;
        $this->client = $client;
    }

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @return \AmoCRM\OAuth2\Client\Provider\AmoCRM
     */
    public function make(?LoggerInterface $logger): AmoCrmProvider
    {
        $providerData = $this->client->toArray();
        $providerData['baseDomain'] = $this->baseDomain;
        $providerData['state'] = uniqid('amo-', true);

        return new AmoCrmProvider($providerData, [
            'httpClient' => new HttpClient([
                'handler'                       => $this->makeHttpHandler($logger),
                RequestOptions::VERIFY          => false,
                RequestOptions::TIMEOUT         => 100,
                RequestOptions::CONNECT_TIMEOUT => 100
            ])
        ]);
    }

    /**
     * @param \Psr\Log\LoggerInterface|null $logger
     * @return \GuzzleHttp\HandlerStack
     */
    private function makeHttpHandler(?LoggerInterface $logger): HandlerStack
    {
        $stack = new HandlerStack(choose_handler());
        if ($logger) {
            $stack->push(function (callable $handler) use ($logger) {
                return new LoggingMiddleware($handler, $logger);
            }, 'http_logger');
        }
        $stack->push(Middleware::redirect(), 'allow_redirects');
        // skip cookie middleware
        $stack->push(Middleware::prepareBody(), 'prepare_body');

        return $stack;
    }
}