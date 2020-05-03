<?php

namespace AmoPRO\AmoCRM\Middleware;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class LoggingMiddleware
{
    /** @var callable */
    private $nextHandler;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param callable $nextHandler Next handler to invoke.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(callable $nextHandler, LoggerInterface $logger)
    {
        $this->nextHandler = $nextHandler;
        $this->logger = $logger;
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return
     */
    public function __invoke(RequestInterface $request, array $options)
    {
        $fn = $this->nextHandler;

        $reqId = uniqid('', true);

        $this->logger->debug(sprintf('[%s] %s %s%s %s',
            $reqId,
            $request->getMethod(),
            $request->getUri()->getHost(),
            $request->getUri()->getPath(),
            $request->getBody()->getContents()
        ));

        $request->getBody()->rewind();

        return $fn($request, $options)->then(function (ResponseInterface $response) use ($reqId) {
            $this->logger->debug(sprintf('[%s] %s %s',
                $reqId,
                $response->getStatusCode(),
                $response->getBody()->getContents()
            ));

            $response->getBody()->rewind();

            return $response;
        }, function ($exception) use ($reqId) {
            $message = "[{$reqId}] ";
            if ($exception instanceof RequestException && ($response = $exception->getResponse())) {
                $message .= $response->getStatusCode() . ' ';
                $message .= $response->getBody()->getContents();
                $response->getBody()->rewind();
            } else {
                $message .= $exception->getCode() . ' ' . $exception->getMessage();
            }

            $this->logger->error($message);

            throw $exception;
        });
    }
}