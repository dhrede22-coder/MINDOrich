<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistoricalSale extends Model
{
    protected $fillable = [
        'sales_date',
        'or_number',
        'customer_name',
        'sale_type',
        'payment_method',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'sales_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(HistoricalSaleItem::class);
    }
}