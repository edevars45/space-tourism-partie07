<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    protected $fillable = [
        'name','slug','order','description','distance','travel_time','image','published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
}
