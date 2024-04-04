<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GeneaLabs\LaravelModelCaching\CachedModel;

class Item extends CachedModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slot',
        'type',
        'element',
        'file',
        'rarity',
        'level',
        'cost',
        'sell',
        'salvage',
        'quantity',
        'currency',
        'health',
        'attack',
        'defense',
        'accuracy',
        'evasion',
        'luck',
    ];
}
