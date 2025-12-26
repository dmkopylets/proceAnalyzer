<?php

namespace App\Services\Exchanges;

use App\Services\Exchanges\Support\FileCache;

class BinanceExchange extends AbstractExchange
{
    private const BASE_URI = 'https://api.binance.com';

    private array $symbolMap = [];

    public function getName(): string
    {
        return 'binance';
    }

    private function loadSymbolMap(): void
    {
        if (!empty($this->symbolMap)) {
            return;
        }

        $cache = new FileCache(
            __DIR__ . '/../../../storage/cache/binance_exchange_info.json',
            3600 // 1 година
        );

        $data = $cache->get();

        if ($data === null) {
            $data = $this->get(self::BASE_URI, '/api/v3/exchangeInfo');
            $cache->put($data);
        }

        foreach ($data['symbols'] as $symbol) {
            if ($symbol['status'] !== 'TRADING') {
                continue;
            }

            $this->symbolMap[$symbol['symbol']] =
                $symbol['baseAsset'] . '/' . $symbol['quoteAsset'];
        }
    }

    public function getPairs(): array
    {
        $this->loadSymbolMap();
        return array_values($this->symbolMap);
    }

    public function getPrices(): array
    {
        $this->loadSymbolMap();

        $data = $this->get(self::BASE_URI, '/api/v3/ticker/price');

        $prices = [];

        foreach ($data as $row) {
            if (!isset($this->symbolMap[$row['symbol']])) {
                continue;
            }

            $prices[$this->symbolMap[$row['symbol']]] =
                (float) $row['price'];
        }

        return $prices;
    }
}
