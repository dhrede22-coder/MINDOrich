<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tribe extends Model
{
    protected $fillable = [
        'tribe_name',
        'cover_image',
        'description',
        'history',
        'location',
        'language',
        'status',
    ];

    public function producers(): HasMany
    {
        return $this->hasMany(Producer::class);
    }
}