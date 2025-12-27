<?php

namespace App\Services\Exchanges;

class PoloniexExchange extends AbstractExchange
{
    private const BASE_URI = 'https://api.poloniex.com';

    public function getName(): string
    {
        return 'poloniex';
    }

    public function getPairs(): array
    {
        $data = $this->get(self::BASE_URI, '/markets/ticker24h');

        $pairs = [];

        foreach ($data as $ticker) {
            if (!isset($ticker['displayName'])) {
                continue;
            }

            // displayName уже у форматі BTC/USDT
            $pairs[] = $ticker['displayName'];
        }

        return $pairs;
    }

    public function getPrices(): array
    {
        $data = $this->get(self::BASE_URI, '/markets/ticker24h');

        $prices = [];

        foreach ($data as $ticker) {
            if (
                !isset($ticker['displayName'], $ticker['close'])
            ) {
                continue;
            }

            $prices[$ticker['displayName']] =
                (float) $ticker['close'];
        }

        return $prices;
    }
}
