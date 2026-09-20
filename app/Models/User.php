<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;
use App\Models\Sale;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * ============================================================
     * MASS ASSIGNABLE FIELDS
     * ============================================================
     */
    protected $fillable = [

        // User / Account Information
        'role_id',
        'name',
        'email',
        'profile_image',
        'password',

        // Customer Information
        'contact_number',
        'address',

        // Customer Verification Information
        'id_type',
        'id_number',
        'id_image',
        'verification_status',
        'verified_at',
        'verification_notes',

        // Delivery Information
'house_street',
'barangay',
'municipality_city',
'province',
'postal_code',
'landmark',

// Valid ID Images
'id_front_image',
'id_back_image',

        // Customer Notification Preferences
        'order_notifications',
        'product_notifications',
    ];

    /**
     * ============================================================
     * HIDDEN FIELDS
     * ============================================================
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ============================================================
     * ATTRIBUTE CASTS
     * ============================================================
     */
    protected function casts(): array
    {
        return [

            // Email verification date
            'email_verified_at' => 'datetime',

            // Automatically hash password
            'password' => 'hashed',

            // Customer verification date
            'verified_at' => 'datetime',

            // Customer notification preferences
            'order_notifications' => 'boolean',
            'product_notifications' => 'boolean',
        ];
    }

    /**
     * ============================================================
     * USER → ROLE
     * ============================================================
     *
     * A User belongs to one Role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * ============================================================
     * USER → SALES / ORDERS
     * ============================================================
     *
     * A User can have many sales/orders.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function reviews(): HasMany
{
    return $this->hasMany(ProductReview::class);
}

public function favorites(): BelongsToMany
{
    return $this->belongsToMany(Product::class, 'favorites')
        ->withTimestamps();
}

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}