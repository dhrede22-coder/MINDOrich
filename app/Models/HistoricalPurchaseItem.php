<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricalPurchaseItem extends Model
{
    protected $fillable = [
        'historical_purchase_id',
        'product_id',
        'quantity_in',
        'reject_quantity',
        'good_quantity',
        'purchase_price',
        'remaining_quantity',
        'received_at',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'received_at' => 'date',
    ];

    public function historicalPurchase(): BelongsTo
    {
        return $this->belongsTo(HistoricalPurchase::class);
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