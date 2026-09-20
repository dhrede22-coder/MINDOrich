<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    protected $fillable = [
        'sale_number',
        'user_id',
        'sale_type',
        'payment_method',
        'payment_status',
        'status',
        'total_amount',
        'notes',
        'gcash_reference',
'gcash_proof',
'gcash_verified_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function reviews(): HasMany
{
    return $this->hasMany(ProductReview::class);
}
}