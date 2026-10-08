<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
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

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function fifoAllocations(): HasMany
    {
        return $this->hasMany(SaleItemFifoAllocation::class);
    }
}