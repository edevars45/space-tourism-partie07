<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',             // Nom FR
        'name_en',          // Nom EN
        'slug',
        'description',      // Description FR
        'description_en',   // Description EN
        'website_url',
        'image_path',       // ex : "technologies/spaceport.jpg"
        'is_published',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order'        => 'integer',
    ];
}
