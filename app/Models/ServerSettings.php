<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use GeneaLabs\LaravelModelCaching\CachedModel;

class ServerSettings extends CachedModel
{
    use HasFactory;

    protected $table = 'server_settings';

    protected $fillable = [
        'name',
        'value',
    ];
}
