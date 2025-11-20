<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrewMember extends Model
{
    use HasFactory;

    // Je sécurise l’assignation massive
    protected $fillable = [
        'name',
        'slug',
        'role',
        'bio',
        'role_en',
        'bio_en',
        'order',
        'is_published',
        'image_path',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
