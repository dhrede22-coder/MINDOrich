<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producer extends Model
{
    protected $fillable = [
        'tribe_id',
        'producer_name',
        'photo',
        'gender',
        'birthdate',
        'contact_number',
        'address',
        'biography',
        'specialization',
        'years_of_experience',
        'status',
    ];

    public function tribe(): BelongsTo
    {
        return $this->belongsTo(Tribe::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
    public function historicalPurchases(): HasMany
{
    return $this->hasMany(HistoricalPurchase::class);
}
}