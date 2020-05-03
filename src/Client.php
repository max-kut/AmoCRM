<?php

namespace AmoPRO\AmoCRM;

use AmoPRO\AmoCRM\Auth\Auth;
use AmoPRO\AmoCRM\Exceptions\Http\UnauthorizedException;
use AmoPRO\AmoCRM\Exceptions\NotDefinedMethodException;
use AmoPRO\AmoCRM\Middleware\ApiErrorsMiddleware;
use AmoPRO\AmoCRM\Middleware\LoggingMiddleware;
use AmoPRO\AmoCRM\Support\Str;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use function GuzzleHttp\choose_handler;

/**
 * Class Client
 *
 * @package AmoPRO\AmoCRM
 * @property-read \AmoPRO\AmoCRM\Methods\Account $account
 * @property-read \AmoPRO\AmoCRM\Methods\Leads $leads
 * @property-read \AmoPRO\AmoCRM\Methods\Contacts $contacts
 * @property-read \AmoPRO\AmoCRM\Methods\Companies $companies
 * @property-read \AmoPRO\AmoCRM\Methods\Customers $customers
 * @property-read \AmoPRO\AmoCRM\Methods\Fields $fields
 * @property-read \AmoPRO\AmoCRM\Methods\Notes $notes
 * @property-read \AmoPRO\AmoCRM\Methods\Tasks $tasks
 * @property-read \AmoPRO\AmoCRM\Methods\Catalogs $catalogs
 * @property-read \AmoPRO\AmoCRM\Methods\CatalogElements $catalog_elements
 * @property-read \AmoPRO\AmoCRM\Methods\ProductsSettings $products_settings
 * @property-read \AmoPRO\AmoCRM\Methods\Salesbot $salesbot
 * @property-read \AmoPRO\AmoCRM\Methods\UrlShortener $url_shortener
 * @property-read \AmoPRO\AmoCRM\Methods\Webhooks $webhooks
 * @property-read \AmoPRO\AmoCRM\Methods\Widgets $widgets
 */
class Client
{
    /** @var \AmoPRO\AmoCRM\Auth\Auth */
    private $auth;
    /** @var \Psr\Log\LoggerInterface $logger */
    private $logger;
    /** @var \GuzzleHttp\Client $httpClient */
    private $httpClient;

    private $methods = [];

    /**
     * Client constructor.
     *
     * @param \AmoPRO\AmoCRM\Auth\Auth $auth
     */
    public function __construct(Auth $auth, LoggerInterface $logger)
    {
        $this->auth = $auth;
        $this->logger = $logger;
        $this->httpClient = $this->makeHttpClient();
    }

    /**
     * @return \GuzzleHttp\Client
     */
    private function makeHttpClient(): HttpClient
    {
        return new HttpClient([
            'base_uri'              => $this->auth->getDomain(),
            'handler'               => $this->getHttpStackHandler(),
            RequestOptions::TIMEOUT => 100,
            RequestOptions::DELAY   => 150,
            RequestOptions::VERIFY  => false,
            RequestOptions::HEADERS => [
                'User-Agent' => 'AmoCRM api client'
            ]
        ]);
    }

    /**
     * @param $name
     * @return mixed
     * @throws \AmoPRO\AmoCRM\Exceptions\NotDefinedMethodException
     * @noinspection MagicMethodsValidityInspection
     */
    public function __get($name)
    {
        if (isset($this->methods[$name])) {
            return $this->methods[$name];
        }

        $className = __NAMESPACE__ . '\\Methods\\' . Str::studly($name);

        if (!class_exists($className)) {
            throw new NotDefinedMethodException(sprintf('Method "%s" not defined.', $name));
        }

        return $this->methods[$name] = new $className($this);
    }

    /**
     * @param $level
     * @param string $message
     * @param array $context
     */
    public function log($level, string $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        return $this->getResponse(
            $request->withHeader('Authorization', 'Bearer ' . $this->auth->getAccessToken())
        );
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param int $attempt
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    private function getResponse(RequestInterface $request, $attempt = 1): ResponseInterface
    {
        try {
            return $this->httpClient->send($request);
        } catch (UnauthorizedException $exception) {
            if($this->auth->requestNewToken() && $attempt < 5){
                usleep(500000);
                return $this->getResponse($request, $attempt + 1);
            }

            throw $exception;
        }
    }

    /**
     * @return \GuzzleHttp\HandlerStack
     */
    private function getHttpStackHandler()
    {
        $stack = new HandlerStack(choose_handler());
        $stack->push(function (callable $handler) {
            return new LoggingMiddleware($handler, $this->logger);
        }, 'http_logger');
        $stack->push(function (callable $handler) {
            return new ApiErrorsMiddleware($handler);
        }, 'http_errors');
        $stack->push(Middleware::prepareBody(), 'prepare_body');

        return $stack;
    }
}
