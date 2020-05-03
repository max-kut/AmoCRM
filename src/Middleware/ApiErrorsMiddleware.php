<?php

namespace AmoPRO\AmoCRM\Middleware;

use AmoPRO\AmoCRM\Exceptions\Http\AccountBlockedException;
use AmoPRO\AmoCRM\Exceptions\Http\PaymentRequiredException;
use AmoPRO\AmoCRM\Exceptions\Http\TooManyRequestsException;
use AmoPRO\AmoCRM\Exceptions\Http\UnauthorizedException;
use AmoPRO\AmoCRM\Support\Arr;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiErrorsMiddleware
{
    /** @var callable */
    private $nextHandler;

    /**
     * @param callable $nextHandler Next handler to invoke.
     */
    public function __construct(callable $nextHandler)
    {
        $this->nextHandler = $nextHandler;
    }

    /**
     * @param \Psr\Http\Message\RequestInterface $request
     * @param array $options
     * @return mixed
     */
    public function __invoke(RequestInterface $request, array $options)
    {
        $fn = $this->nextHandler;

        return $fn($request, $options)->then(function (ResponseInterface $response) use ($request) {
            $code = $response->getStatusCode();
            switch ($code) {
                case 401:
                    throw new UnauthorizedException(Arr::get($this->responseToArray($response), 'error'));
                case 402:
                    throw PaymentRequiredException::create($request, $response);
                case 403:
                    throw AccountBlockedException::create($request, $response);
                case 429:

                    throw TooManyRequestsException::create($request, $response);
                default:
                    if ($code < 400) {
                        return $response;
                    }
                    throw RequestException::create($request, $response);
            }
        });
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array
     */
    private function responseToArray(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}