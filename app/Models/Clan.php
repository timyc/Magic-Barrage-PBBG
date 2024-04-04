<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tag',
        'description',
        'max_size',
        'level',
        'exp',
        'coins',
        'food',
        'wood',
        'stone',
        'iron',
    ];
}
