<?php

namespace App\Services\Exchanges;

use App\Services\Exchanges\Support\FileCache;

class WhitebitExchange extends AbstractExchange
{
    private const BASE_URI = 'https://whitebit.com';

    private array $symbolMap = [];

    public function getName(): string
    {
        return 'whitebit';
    }

    private function loadSymbolMap(): void
    {
        if (!empty($this->symbolMap)) {
            return;
        }

        $cache = new FileCache(
            __DIR__ . '/../../../storage/cache/whitebit_markets.json',
            3600
        );

        $data = $cache->get();

        if ($data === null) {
            $data = $this->get(self::BASE_URI, '/api/v4/public/markets');
            $cache->put($data);
        }

        foreach ($data as $info) {
            if (($info['type'] ?? '') !== 'spot') {
                continue;
            }

            if (!isset($info['name'], $info['stock'], $info['money'])) {
                continue;
            }

            // ETH_BTC → ETH/BTC
            $this->symbolMap[$info['name']] =
                $info['stock'] . '/' . $info['money'];
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

        $data = $this->get(self::BASE_URI, '/api/v4/public/ticker');

        $prices = [];

        foreach ($data as $symbol => $ticker) {
            if (!isset($this->symbolMap[$symbol])) {
                continue;
            }

            if (!isset($ticker['last_price'])) {
                continue;
            }

            $prices[$this->symbolMap[$symbol]] =
                (float) $ticker['last_price'];
        }

        return $prices;
    }

}
