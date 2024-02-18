<?php

namespace App\Service;

use GuzzleHttp\Client;

class GuzzleClientService
{
    private $httpClient;

    public function __construct(string $baseUri)
    {
        $this->httpClient = new Client([
            'base_uri' => $baseUri,
        ]);
    }

    public function sendRequest(string $method, string $uri, array $options = [])
    {
        return $this->httpClient->request($method, $uri, $options);
    }
}