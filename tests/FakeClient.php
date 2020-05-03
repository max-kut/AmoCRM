<?php

namespace Tests;

use AmoPRO\AmoCRM\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class FakeClient extends Client
{
    public function send(RequestInterface $request): ResponseInterface
    {
        $key = $request->getMethod() . ' ' . $request->getUri()->getPath();
        $responseFiles = [
            'GET /api/v2/account' => __DIR__ . '/fake_responses/account.json',
            'GET /api/v2/leads'   => __DIR__ . '/fake_responses/get_leads.json',
        ];

        return new Response(200, [], file_get_contents($responseFiles[$key]));
    }
}