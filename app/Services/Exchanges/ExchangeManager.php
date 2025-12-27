<?php

namespace App\Services\Exchanges;
class ExchangeManager
{
    /**
     * @return ExchangeInterface[]
     */
    public function all(): array
    {
        return [
            new BinanceExchange(),
            new WhitebitExchange(),
            new PoloniexExchange(),
            // new JbexExchange(),
            // new BybitExchange(),


        ];
    }
}

