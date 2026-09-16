<?php 
 
namespace App\Models; 
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use Illuminate\Database\Eloquent\Relations\HasMany; 
 
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
 
    public function inventoryMovements(): HasMany 
    { 
        return $this->hasMany(InventoryMovement::class); 
    } 

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}