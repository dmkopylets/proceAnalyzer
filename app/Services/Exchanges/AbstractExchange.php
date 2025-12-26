<?php

namespace App\Services\Exchanges;

use GuzzleHttp\Client;

abstract class AbstractExchange implements ExchangeInterface
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
        ]);
    }

    /**
     * Хелпер для HTTP GET
     */
    protected function get(string $baseUri, string $uri): array
    {
        $response = $this->client->get($baseUri . $uri);

        return json_decode(
            $response->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}

