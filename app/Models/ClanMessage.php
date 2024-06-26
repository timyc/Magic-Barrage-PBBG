<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClanMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_clan';

    protected $fillable = [
        'clan_id',
        'char_id',
        'char_name',
        'message',
    ];
}
