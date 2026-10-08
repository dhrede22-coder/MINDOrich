<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItemFifoAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_item_id',
        'purchase_item_id',
        'quantity',
        'unit_cost',
        'cost_subtotal',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'cost_subtotal' => 'decimal:2',
    ];

    public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }

    public function purchaseItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseItem::class);
    }
}