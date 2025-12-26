<?php

namespace App\Services\Exchanges;

interface ExchangeInterface
{
    /**
     * Назва біржі (binance, bybit, whitebit...)
     */
    public function getName(): string;

    /**
     * Повертає список торгових пар у форматі:
     * [
     *   'BTC/USDT',
     *   'ETH/USDT',
     * ]
     */
    public function getPairs(): array;

    /**
     * Повертає ціни у форматі:
     * [
     *   'BTC/USDT' => 43000.12,
     *   'ETH/USDT' => 2300.50,
     * ]
     */
    public function getPrices(): array;
}

