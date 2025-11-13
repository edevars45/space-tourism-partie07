<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrewMember extends Model
{
    use HasFactory;

    // Je sécurise l’assignation massive
    protected $fillable = [
        'name', 'slug', 'role', 'bio', 'image_path', 'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
