<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricalPurchase extends Model
{
    protected $fillable = [
        'purchase_number',
        'producer_id',
        'purchase_date',
        'status',
        'total_purchase_cost',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_purchase_cost' => 'decimal:2',
    ];

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(HistoricalPurchaseItem::class);
    }
}