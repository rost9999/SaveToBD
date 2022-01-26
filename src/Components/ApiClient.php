<?php

namespace Components;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://wr2st12.myshopify.com/admin/api/2021-10/',
            'timeout' => 2.0,
            'auth' => ['db45daa9593bee2a57da19cc5c6a8b44', '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']
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function doRequest($method, $uri)
    {
        $response = $this->client->request($method, $uri);
        return json_decode($response->getBody());
    }
}