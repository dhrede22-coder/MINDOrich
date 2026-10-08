<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricalSaleItem extends Model
{
    protected $fillable = [
        'historical_sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function historicalSale(): BelongsTo
    {
        return $this->belongsTo(HistoricalSale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function fifoAllocations(): HasMany
    {
        return $this->hasMany(HistoricalFifoAllocation::class);
    }
}