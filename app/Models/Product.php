<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'producer_id',
        'category_id',
        'product_name',
        'description',
        'price',
        'stock',
        'minimum_stock',
        'featured_image',
        'status',
    ];

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function historicalSaleItems(): HasMany
{
    return $this->hasMany(HistoricalSaleItem::class);
}

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')
            ->withTimestamps();
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class, 'product_promotions')
            ->withTimestamps();
    }

    public function pricing(): array
    {
        $originalPrice = round((float) $this->price, 2);

        $effectivePrice = $originalPrice;
        $activePromotion = null;

        $promotions = $this->promotions()
            ->currentlyActive()
            ->get();

        foreach ($promotions as $promotion) {
            $discountedPrice = $originalPrice;

            if ($promotion->discount_type === 'percentage') {
                $discount = $originalPrice
                    * ((float) $promotion->discount_value / 100);

                $discountedPrice = $originalPrice - $discount;
            }

            if ($promotion->discount_type === 'fixed') {
                $discountedPrice = $originalPrice
                    - (float) $promotion->discount_value;
            }

            $discountedPrice = max(
                0,
                round($discountedPrice, 2)
            );

            if ($discountedPrice < $effectivePrice) {
                $effectivePrice = $discountedPrice;
                $activePromotion = $promotion;
            }
        }

        return [
            'original_price' => $originalPrice,
            'effective_price' => $effectivePrice,
            'discount_amount' => round(
                $originalPrice - $effectivePrice,
                2
            ),
            'promotion' => $activePromotion,
        ];
    }

    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function historicalPurchaseItems(): HasMany
{
    return $this->hasMany(HistoricalPurchaseItem::class);
}

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}