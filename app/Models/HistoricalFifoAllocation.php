<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalFifoAllocation extends Model
{
    protected $fillable = [
        'historical_sale_item_id',
        'historical_purchase_item_id',
        'quantity',
        'unit_cost',
        'cost_subtotal',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'cost_subtotal' => 'decimal:2',
    ];

    public function historicalSaleItem(): BelongsTo
    {
        return $this->belongsTo(HistoricalSaleItem::class);
    }

    public function historicalPurchaseItem(): BelongsTo
    {
        return $this->belongsTo(HistoricalPurchaseItem::class);
    }
}