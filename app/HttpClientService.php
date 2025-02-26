<?php

namespace App;

use GuzzleHttp\Client;

class HttpClientService
{
    private string $baseUri;
    private Client $client;

    public function __construct(string $baseUri)
    {
        $this->baseUri = rtrim($baseUri, '/');
        $this->client = new Client([
            'base_uri' => $this->baseUri,
            'headers'  => ['Content-Type' => 'application/json']
        ]);
    }

    public function getHelloString(string $name): string
    {
        $response = $this->client->get("/hello/{$name}");
        $body = json_decode((string)$response->getBody(), true);

        return $body['message'] ?? '';
    }
}
