<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GeneaLabs\LaravelModelCaching\CachedModel;

class Mob extends CachedModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'hp',
        'atk',
        'def',
        'agi',
        'acc',
        'crit',
        'xhit',
        'exp',
        'race',
        'element',
        'area'
    ];
}
