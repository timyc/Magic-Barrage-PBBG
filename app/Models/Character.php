<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'race',
        'title',
        'gender',
        'class',
        'level',
        'exp',
        'mode',
        'area',
        'x',
        'y',
        'coins',
        'food',
        'wood',
        'stone',
        'iron',
        'health',
        'attack',
        'defense',
        'accuracy',
        'evasion',
        'luck',
        'crit_chance',
        'crit_damage',
        'crit_resistance',
        'multiattack',
        'reputation',
        'main_hand',
        'off_hand',
        'helmet',
        'gauntlets',
        'shoulders',
        'torso',
        'leggings',
        'boots',
        'action',
        'actions_max',
        'actions_current',
    ];

    public function initEquipment() {
        return [
            'main_hand' => null,
            'off_hand' => null,
            'helmet' => null,
            'gauntlets' => null,
            'shoulders' => null,
            'torso' => null,
            'leggings' => null,
            'boots' => null,
        ];
    }
}
