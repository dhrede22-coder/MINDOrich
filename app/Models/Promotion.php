<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_type',
        'discount_value',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'status' => 'boolean',
    ];
    public function scopeCurrentlyActive($query)
{
    return $query
        ->where('status', true)
        ->where(function ($query) {
            $query
                ->whereNull('starts_at')
                ->orWhere('starts_at', '<=', now());
        })
        ->where(function ($query) {
            $query
                ->whereNull('ends_at')
                ->orWhere('ends_at', '>=', now());
        });
}

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_promotions')
            ->withTimestamps();
    }
}