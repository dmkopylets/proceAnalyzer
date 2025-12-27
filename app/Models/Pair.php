<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pair extends Model
{
    protected $fillable = [
        'symbol', // BTC/USDT
        'base',   // BTC
        'quote',  // USDT
    ];

    public function prices(): HasMany
    {
        return $this->hasMany(ExchangePrice::class);
    }
}
