<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorldChatMessage extends Model
{
    use HasFactory;
    
    protected $table = 'chat_world';

    protected $fillable = [
        'char_id',
        'name',
        'gender',
        'rank',
        'message',
        'channel'
    ];
    
}
