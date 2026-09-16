<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title',
        'featured_image',
        'content',
        'status',
        'published_at',
    ];
}