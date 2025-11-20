<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    protected $table = 'planets';

    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'order',
        'distance',
        'travel_time',
        'description',
        'description_en',
        'image',        // chemin de l'image (ex : planets/xxx.png)
        'published',    // bool
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
