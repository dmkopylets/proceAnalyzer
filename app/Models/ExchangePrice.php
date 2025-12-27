<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangePrice extends Model
{
    protected $fillable = [
        'exchange_id',
        'pair_id',
        'price',
    ];

    public function exchange(): BelongsTo
    {
        return $this->belongsTo(Exchange::class);
    }

    public function pair(): BelongsTo
    {
        return $this->belongsTo(Pair::class);
    }
}
